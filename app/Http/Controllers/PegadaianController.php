<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables;
use App\Models\Validation;
use App\Models\Pegadaian;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
// use Barryvdh\DomPDF\PDF;
use PDF;

class PegadaianController extends Controller
{

    public function datatables(Request $request)
    {
        if($request->ajax()) {
            $query = Pegadaian::select('pegadaians.*')->whereRaw('1 = 1');
            return datatables($query)
                ->addIndexColumn()
                ->editColumn('jumlah_pinjaman', function($data) {
                    return 'Rp. '.number_format($data->jumlah_pinjaman);
                })
                ->editColumn('jumlah_tebusan', function($data) {
                    return 'Rp. '.number_format($data->jumlah_tebusan);
                })
                ->editColumn('status', function($data) {
                    $html = '';
                    if($data->status == 0) {
                        $html .= '<span class "label label-warning">nihil</span>';
                    } else if($data->status == 1) {
                        $html .= '<span class "label label-success">Tebus</span>';
                    } else if($data->status == 2) {
                        $html .= '<span class "label label-warning">Perpanjang</span>';
                    } else if($data->status == 3) {
                        $html .= '<span class "label label-danger">Lelang</span>';
                    }
                    return $html;
                })
                ->editColumn('created_at', function($data) {
                    return Carbon::make($data->created_at);
                })
                ->addColumn('tebus', function ($data) {
                    if($data->status == 1 || $data->status == 3) {
                        $html = "";
                    } else {
                        $html = '<button type="button" name="tebus" url="' . route('pegadaian.tebus', $data->uuid) . '" class="tebus btn btn-success btn-xs btn-flat" data-toggle="tooltip" data-placement="bottom" title="Tebus"><i class = "fa fa-money"></i> Tebus</button><br/> ';
                    }
                    return $html;
                })
                ->addColumn('perpanjang', function($data) {
                    if($data->status == 2) {
                        $html = "";
                    } else if($data->status == 1 || $data->status == 3){
                        $html = "";
                    } else {
                        $html = '<button type="button" name="perpanjang" url="' . route('pegadaian.form_perpanjang', $data->uuid) . '" class="perpanjang btn btn-warning btn-xs btn-flat" data-toggle="tooltip" data-placement="bottom" title="Perpanjang"><i class = "fa fa-calendar"></i> Perpanjang</button></br> ';
                    }
                    return $html;
                })
                ->addColumn('lelang', function($data) {
                    if($data->status == 3) {
                        $html = "";
                    } else if($data->status == 1) {
                        $html = "";
                    } else {
                        $html = '<button type="button" name="lelang" url="' . route('pegadaian.lelang', $data->uuid) . '" class="lelang btn btn-danger btn-xs btn-flat" data-toggle="tooltip" data-placement="bottom" title="Lelang"><i class = "fa fa-dollar"></i> Lelang</button><br/> ';
                    }
                    return $html;
                })
                ->addColumn('view', function($data) {
                    $html = '<button type="button" name="report" url="' . route('pegadaian.getReport', $data->uuid) . '" class="report btn btn-primary btn-xs btn-flat" data-toggle="tooltip" data-placement="bottom" title="Lihat Detail"><i class = "fa fa-eye"></i> Lihat Detail</button><br/> ';
                    return $html;
                })
                ->escapeColumns([])
                ->make(true);
        }
    }

    public function remindNotification()
    {
        $pegadaian = Pegadaian::where('tanggal_jatuh_tempo', date('Y-m-d'))->where('status', '!=', 3)->orWhere('status', 2)->get();
        return $pegadaian;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = [
            'pegadaian' => $this->remindNotification()
        ];
        return view('pages.dashboard.list_pegadaian', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data = [
            'action' => route('pegadaian.store'),
        ];
        return view('pages.dashboard.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $rules = [
            'nik_peminjam' => 'required|numeric|min:16',
            'nama_peminjam' => 'required',
            'alamat_peminjam' => 'required',
            'no_telepon' => 'required',
            'tanggal_masuk_pinjaman' => 'required',
            'tanggal_jatuh_tempo' => 'required',
            'jumlah_pinjaman' => 'required|numeric',
            'jumlah_tebusan' => 'required|numeric',
            'keterangan_jaminan' => 'required'
        ];

        $errors = Validator::make(
            $request->all(),
            $rules,
            Validation::ValidationMessage()
        );

        if($errors->fails()) {
            return response()->json([
                'status' => 'failed',
                'messages' => $errors->errors()->all()
            ]);
        }

        $request->request->add([
            'nik_peminjam' => $request->nik_peminjam,
            'nama_peminjam' => ucwords($request->nama_peminjam),
            'alamat_peminjam' => $request->alamat_peminjam,
            'no_telepon' => $request->no_telepon,
            'tanggal_masuk_pinjaman' => Carbon::make($request->tanggal_masuk_pinjaman),
            'tanggal_jatuh_tempo' => Carbon::make($request->tanggal_jatuh_tempo),
            'jumlah_pinjaman' => $request->jumlah_pinjaman,
            'jumlah_tebusan' => $request->jumlah_tebusan,
            'keterangan_jaminan' => $request->keterangan_jaminan,
            'status' => 0,
        ]);

        DB::beginTransaction();

        Pegadaian::create($request->all());

        DB::commit();

        return response()->json([
            'status' => 'success',
            'messages' => 'Data Sukses Ditambah'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function tebus($uuid)
    {
        $pegadaian = Pegadaian::where('uuid', $uuid)->first();
        DB::beginTransaction();

        $pegadaian->update([
            'status' => 1,
        ]);

        DB::commit();

        return response()->json([
            'status' => 'success',
            'messages' => 'Jaminan Sukses Ditebus'
        ]);
    }

    public function form_perpanjang($uuid)
    {
        $data = [
            'pegadaian' => Pegadaian::where('uuid', $uuid)->first(),
            'action' => route('pegadaian.perpanjang', $uuid)
        ];
        return view('pages.dashboard.form_perpanjangan', $data);

    }

    public function perpanjang(Request $request, $uuid)
    {
        $rules = [
            'tanggal_jatuh_tempo1' => 'required'
        ];

        $errors = Validator::make(
            $request->all(),
            $rules,
            Validation::ValidationMessage()
        );

        if($errors->fails()) {
            return response()->json([
                'status' => 'failed',
                'messages' => $errors->errors()->all()
            ]);
        }

        $pegadaian = Pegadaian::where('uuid', $uuid)->first();

        if(Carbon::make($request->tanggal_jatuh_tempo1) <= $pegadaian->tanggal_jatuh_tempo) {
            return response()->json([
                'status' => 'failed',
                'messages' => ['Tanggal Jatuh Tempo Harus Lebih Dari Tanggal Jatuh Tempo Sebelumnya']
            ]);
        }

        if(Carbon::make($request->tanggal_jatuh_tempo1) <= $pegadaian->tanggal_masuk_pinjaman) {
            return response()->json([
                'status' => 'failed',
                'messages' => ['Tanggal Jatuh Tempo Harus Lebih Dari Tanggal Masuk Pinjaman']
            ]);
        }

        DB::beginTransaction();

        $pegadaian->update([
            'tanggal_jatuh_tempo' => Carbon::make($request->tanggal_jatuh_tempo1),
            'status' => 2,
        ]);

        DB::commit();

        return response()->json([
            'status' => 'success',
            'messages' => 'Jaminan Sukses Diperpanjang'
        ]);
    }

    public function lelang($uuid)
    {
        $pegadaian = Pegadaian::where('uuid', $uuid)->first();
        DB::beginTransaction();

        $pegadaian->update([
            'status' => 3,
        ]);

        DB::commit();

        return response()->json([
            'status' => 'success',
            'messages' => 'Jaminan Sukses Dilelang'
        ]);
    }

    public function getReport($uuid)
    {
        $pegadaian = Pegadaian::where('uuid', $uuid)->first();

        $data = [
            'pegadaian' => $pegadaian,
            'button' => route('pegadaian.downloadReport', $uuid)
        ];

        return view('pages.dashboard.pdf', $data);
    }

    public function downloadReport($uuid)
    {
        $pegadaian = Pegadaian::where('uuid', $uuid)->first();

        $data = [
            'pegadaian' => $pegadaian,
        ];

        set_time_limit(300);

        $pdf = PDF::loadView('pages.dashboard.pdf', $data);

        return $pdf->download($uuid.".pdf");
    }
}
