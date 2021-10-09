<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables;
use App\Models\Validation;
use App\Models\Pegadaian;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\Perpanjangan;
// use Barryvdh\DomPDF\PDF;
use PDF;

class PegadaianController extends Controller
{

    public function datatables(Request $request)
    {
        if ($request->ajax()) {
            $query = Pegadaian::select('pegadaians.*')->whereRaw('1 = 1');
            return datatables($query)
                ->setRowAttr([
                    'style' => function ($data) {
                        if ($data->status == 3) {
                            return 'color: #FFFFFF;background-color: #dd4b39;';
                        } else if ($data->status == 1) {
                            return 'color: #FFFFFF;background-color: #00a65a;';
                        } else if ($data->status == 2) {
                            return 'color: #FFFFFF;background-color: #f39c12;';
                        }
                    }
                ])
                ->editColumn('jumlah_pinjaman', function ($data) {
                    return 'Rp. ' . number_format($data->jumlah_pinjaman);
                })
                ->editColumn('jumlah_tebusan', function ($data) {
                    return 'Rp. ' . number_format($data->jumlah_tebusan);
                })
                ->editColumn('tanggal_perpanjangan_jatuh_tempo', function ($data) {
                    $check_perpanjangan = Perpanjangan::where('uuid_pegadaian', '=', $data->uuid)->orderByDesc('id')->limit(1)->get();
                    if (empty($check_perpanjangan)) {
                        return '-';
                    } else {
                        foreach ($check_perpanjangan as $key => $value) {
                            return $value->tanggal_perpanjangan_jatuh_tempo;
                        }
                    }
                })
                ->editColumn('tanggal_perpanjangan', function ($data) {
                    $check_perpanjangan = Perpanjangan::where('uuid_pegadaian', '=', $data->uuid)->orderByDesc('id')->limit(1)->get();
                    if (empty($check_perpanjangan)) {
                        return '-';
                    } else {
                        foreach ($check_perpanjangan as $key => $value) {
                            return $value->tanggal_perpanjangan;
                        }
                    }
                })
                ->editColumn('denda', function ($data) {
                    // if(date('Y-m-d') > $data->tanggal_jatuh_tempo) {
                    //     $diff = Carbon::parse(date('Y-m-d'));
                    //     $denda = $diff->diffInDays($data->tanggal_jatuh_tempo) * 10000;
                    //     return 'Rp. '.number_format($denda);
                    // } else {
                    //     return 'Rp. '.number_format(0);
                    // }
                    return 'Rp.' . number_format(Pegadaian::denda($data->uuid));
                })
                ->editColumn('status', function ($data) {
                    $html = '';
                    if ($data->status == 0) {
                        $html .= '<span class "label label-warning">nihil</span>';
                    } else if ($data->status == 1) {
                        $html .= '<span class "label label-success">Tebus</span>';
                    } else if ($data->status == 2) {
                        $html .= '<span class "label label-warning">Perpanjang</span>';
                    } else if ($data->status == 3) {
                        $html .= '<span class "label label-danger">Lelang</span>';
                    }
                    return $html;
                })
                ->editColumn('created_at', function ($data) {
                    return Carbon::make($data->created_at);
                })
                ->addColumn('action', function ($data) {
                    $html = '';
                    $html .= '<button type="button" name="report" url="' . route('pegadaian.getReport', $data->uuid) . '" class="report btn btn-primary btn-xs btn-flat" data-toggle="tooltip" data-placement="bottom" title="Lihat Detail"><i class = "fa fa-eye"></i> Lihat Detail</button><br/> ';
                    $html .= '<button type="button" name="edit" url="' . route('pegadaian.edit', $data->uuid) . '" class="edit btn btn-warning btn-xs btn-flat" data-toggle="tooltip" data-placement="bottom" title="Ubah Data"><i class = "fa fa-pencil"></i> Ubah Data</button><br/> ';
                    $html .= '<button type="button" name="delete" url="' . route('pegadaian.destroy', $data->uuid) . '" class="delete btn btn-danger btn-xs btn-flat" data-toggle="tooltip" data-placement="bottom" title="Hapus Data"><i class = "fa fa-trash"></i> Hapus Data</button><br/> ';
                    if ($data->status == 1 || $data->status == 3) {
                        $html .= "<br/>";
                    } else {
                        $html .= '<button type="button" name="tebus" url="' . route('pegadaian.tebus', $data->uuid) . '" class="tebus btn btn-success btn-xs btn-flat" data-toggle="tooltip" data-placement="bottom" title="Tebus"><i class = "fa fa-money"></i> Tebus</button><br/> ';
                        $html .= '<button type="button" name="perpanjang" url="' . route('pegadaian.form_perpanjang', $data->uuid) . '" class="perpanjang btn btn-warning btn-xs btn-flat" data-toggle="tooltip" data-placement="bottom" title="Perpanjang"><i class = "fa fa-calendar"></i> Perpanjang</button><br/> ';
                    }

                    if ($data->status == 3) {
                        $html .= "<br/>";
                    } else if ($data->status == 1) {
                        $html .= "<br/>";
                    } else {
                        $html .= '<button type="button" name="lelang" url="' . route('pegadaian.lelang', $data->uuid) . '" class="lelang btn btn-danger btn-xs btn-flat" data-toggle="tooltip" data-placement="bottom" title="Lelang"><i class = "fa fa-dollar"></i> Lelang</button><br/> ';
                    }
                    return $html;
                })
                ->escapeColumns([])
                ->make(true);
        }
    }

    public function remindNotification()
    {
        $pegadaian = Pegadaian::where('tanggal_jatuh_tempo', '<=', date('Y-m-d'))->where('status', '!=', 1)->Where('status', '!=', 3)->get();
        return $pegadaian;
    }

    public function listAllNotification()
    {
        $pegadaian = $this->remindNotification();
        $html = '';
        foreach ($pegadaian as $pegadaians) {
            $html .= '<li>';
            $html .= '<a href = "' . route('pegadaian.getReport', $pegadaians->uuid) . '" target = "_blank">';
            $html .= '<i class="fa fa-users text-aqua"></i>' . $pegadaians->nik_peminjam . ' - ' . $pegadaians->nama_peminjam . '</a>';
            $html .= '</li>';
        }
        return $html;
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
            'nik_peminjam' => 'required|numeric',
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

        if (strlen($request->nik_peminjam) > 16 || strlen($request->nik_peminjam) < 16) {
            return response()->json([
                'status' => 'failed',
                'messages' => ['nik harus 16 digit']
            ]);
        }

        if ($errors->fails()) {
            return response()->json([
                'status' => 'failed',
                'messages' => $errors->errors()->all()
            ]);
        }

        if (Carbon::make($request->tanggal_jatuh_tempo) <= Carbon::make($request->tanggal_masuk_pinjaman)) {
            return response()->json([
                'status' => 'failed',
                'messages' => ['Tanggal Jatuh Tempo Harus Lebih Besar Dari Tanggal Pinjam']
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
            'messages' => 'Data Sukses Ditambah',
            'count_notif' => count($this->remindNotification()),
            'html_notif' => $this->listAllNotification()
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
    public function edit($uuid)
    {
        //
        $pegadaian = Pegadaian::where('uuid', $uuid)->first();
        $data = [
            'pegadaian' => $pegadaian,
            'action' => route('pegadaian.update', $uuid)
        ];
        return view('pages.dashboard.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {
        //

        $rules = [
            'nik_peminjam' => 'required|numeric|min:16',
            'nama_peminjam' => 'required',
            'alamat_peminjam' => 'required',
            'no_telepon' => 'required',
            'jumlah_pinjaman' => 'required|numeric',
            'jumlah_tebusan' => 'required|numeric',
            'keterangan_jaminan' => 'required'
        ];

        $errors = Validator::make(
            $request->all(),
            $rules,
            Validation::ValidationMessage()
        );

        if (strlen($request->nik_peminjam) > 16 || strlen($request->nik_peminjam) < 16) {
            return response()->json([
                'status' => 'failed',
                'messages' => ['nik harus 16 digit']
            ]);
        }

        if ($errors->fails()) {
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
            'jumlah_pinjaman' => $request->jumlah_pinjaman,
            'jumlah_tebusan' => $request->jumlah_tebusan,
            'keterangan_jaminan' => $request->keterangan_jaminan,
        ]);

        DB::beginTransaction();

        $pegadaian = Pegadaian::where('uuid', $uuid)->first();
        $pegadaian->update($request->all());

        DB::commit();

        return response()->json([
            'status' => 'success',
            'messages' => 'Data Sukses Diubah',
            'count_notif' => count($this->remindNotification()),
            'html_notif' => $this->listAllNotification()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        //
        $perpanjangan = Perpanjangan::where('uuid_pegadaian', '=', $uuid)->get();

        DB::beginTransaction();

        if ($perpanjangan->count() > 0) {
            foreach ($perpanjangan as $perpanjangans) {
                $perpanjangan_delete = Perpanjangan::where('uuid', $perpanjangans['uuid'])->first();
                $perpanjangan_delete->delete();
            }
        }

        $pegadaian = Pegadaian::where('uuid', $uuid)->first();
        $pegadaian->delete();

        DB::commit();

        return response()->json([
            'status' => 'success',
            'messages' => 'Data Sukses Dihapus',
            'count_notif' => count($this->remindNotification()),
            'html_notif' => $this->listAllNotification()
        ]);
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
            'messages' => 'Jaminan Sukses Ditebus',
            'count_notif' => count($this->remindNotification()),
            'html_notif' => $this->listAllNotification()
        ]);
    }

    public function form_perpanjang($uuid)
    {
        $check_perpanjang = Perpanjangan::where('uuid_pegadaian', '=', $uuid)->orderByDesc('id')->limit(1)->first();

        if(!empty($check_perpanjang)) {
            $pegadaian['uuid'] = $uuid;
            $pegadaian['tanggal_perpanjangan'] = $check_perpanjang['tanggal_perpanjangan'];
            $pegadaian['tanggal_jatuh_tempo'] = $check_perpanjang['tanggal_perpanjangan_jatuh_tempo']; 
        } else if(empty($check_perpanjang)){
            $check_pegadaian = Pegadaian::where('uuid', $uuid)->first();
            $pegadaian['uuid'] = $uuid;
            $pegadaian['tanggal_perpanjangan'] = $check_pegadaian['tanggal_masuk_pinjaman'];
            $pegadaian['tanggal_jatuh_tempo'] = $check_pegadaian['tanggal_jatuh_tempo']; 
        }

        $data = [
            'pegadaian' => $pegadaian,
            'action' => route('pegadaian.perpanjang', $uuid)
        ];
        return view('pages.dashboard.form_perpanjangan', $data);
    }

    public function perpanjang(Request $request, $uuid)
    {
        $rules = [
            'tanggal_perpanjang' => 'required',
            'tanggal_jatuh_tempo1' => 'required'
        ];

        $errors = Validator::make(
            $request->all(),
            $rules,
            Validation::ValidationMessage()
        );

        if ($errors->fails()) {
            return response()->json([
                'status' => 'failed',
                'messages' => $errors->errors()->all()
            ]);
        }

        $pegadaian = Pegadaian::where('uuid', $uuid)->first();

        if (Carbon::make($request->tanggal_jatuh_tempo1) <= $pegadaian->tanggal_jatuh_tempo) {
            return response()->json([
                'status' => 'failed',
                'messages' => ['Tanggal Perpanjangan Jatuh Tempo Lebih Dari Tanggal Jatuh Tempo Sebelumnya']
            ]);
        }

        if (Carbon::make($request->tanggal_jatuh_tempo1) <= $pegadaian->tanggal_masuk_pinjaman) {
            return response()->json([
                'status' => 'failed',
                'messages' => ['Tanggal Perpanjangan Jatuh Tempo Harus Lebih Dari Tanggal Masuk Pinjaman']
            ]);
        }

        if (Carbon::make($request->tanggal_perpanjang) <= $pegadaian->tanggal_jatuh_tempo) {
            return response()->json([
                'status' => 'failed',
                'messages' => ['Tanggal Perpanjangan Harus Lebih Dari Tanggal Jatuh Tempo Sebelumnya']
            ]);
        }

        if (Carbon::make($request->tanggal_perpanjang) <= $pegadaian->tanggal_masuk_pinjaman) {
            return response()->json([
                'status' => 'failed',
                'messages' => ['Tanggal Perpanjangan Harus Lebih Dari Tanggal Masuk Pinjaman']
            ]);
        }

        if (Carbon::make($request->tanggal_jatuh_tempo1) <= Carbon::make($request->tanggal_perpanjang)) {
            return response()->json([
                'status' => 'failed',
                'messages' => ['Tanggal Perpanjangan Jatuh Tempo Harus Lebih Dari Tanggal Perpanjangan']
            ]);
        }

        DB::beginTransaction();

        $pegadaian->update([
            // 'tanggal_jatuh_tempo' => Carbon::make($request->tanggal_jatuh_tempo1),
            'status' => 2,
        ]);

        Perpanjangan::create([
            'uuid_pegadaian' => $uuid,
            'tanggal_perpanjangan' => Carbon::make($request->tanggal_perpanjang),
            'tanggal_perpanjangan_jatuh_tempo' => Carbon::make($request->tanggal_jatuh_tempo1)
        ]);

        DB::commit();

        return response()->json([
            'status' => 'success',
            'messages' => 'Jaminan Sukses Diperpanjang',
            'count_notif' => count($this->remindNotification()),
            'html_notif' => $this->listAllNotification()
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
            'messages' => 'Jaminan Sukses Dilelang',
            'count_notif' => count($this->remindNotification()),
            'html_notif' => $this->listAllNotification()
        ]);
    }

    public function report($uuid)
    {
        $pegadaian = Pegadaian::where('uuid', '=', $uuid)->get();
        if ($pegadaian->count() > 0) {
            foreach ($pegadaian as $pegadaians) {
                $pgd['id'] = $pegadaians['id'];
                $pgd['nik_peminjam'] = $pegadaians['nik_peminjam'];
                $pgd['nama_peminjam'] = $pegadaians['nama_peminjam'];
                $pgd['alamat_peminjam'] = $pegadaians['alamat_peminjam'];
                $pgd['no_telepon'] = $pegadaians['no_telepon'];
                $pgd['tanggal_masuk_pinjaman'] = $pegadaians['tanggal_masuk_pinjaman'];
                $pgd['tanggal_jatuh_tempo'] = $pegadaians['tanggal_jatuh_tempo'];
                $pgd['jumlah_pinjaman'] = $pegadaians['jumlah_pinjaman'];
                $pgd['jumlah_tebusan'] = $pegadaians['jumlah_tebusan'];
                $pgd['telat'] = Pegadaian::telat($uuid);
                $pgd['denda'] = Pegadaian::denda($uuid);
                $pgd['keterangan_jaminan'] = $pegadaians['keterangan_jaminan'];
                if ($pegadaians->status == 0) {
                    $status = 'nihil';
                    $color = '';
                } else if ($pegadaians->status == 1) {
                    $status = 'Ditebus';
                    $color = '#00a65a';
                } else if ($pegadaians->status == 2) {
                    $status = 'Diperpanjang';
                    $color = '#f39c12';
                } else if ($pegadaians->status == 3) {
                    $status = 'Dilelang';
                    $color = '#dd4b39';
                }
                $pgd['status'] = $status;
                $pgd['color'] = $color;
                $pgd['created_at'] = $pegadaians['created_at'];
            }
        } else {
            $pgd = 'empty';
        }
        return $pgd;
    }

    public function getReport($uuid)
    {
        $pegadaian = $this->report($uuid);

        if ($pegadaian == 'empty') {
            return redirect(404);
        }
        // dd($pegadaian);
        $perpanjangan = Perpanjangan::where('uuid_pegadaian', '=', $uuid)->get();

        $data = [
            'pegadaian' => $pegadaian,
            'perpanjangan' => $perpanjangan,
            'print_link' => route('pegadaian.print', $uuid),
            'button' => route('pegadaian.downloadReport', $uuid)
        ];

        return view('pages.dashboard.pdf', $data);
    }

    public function downloadReport($uuid)
    {
        $pegadaian = $this->report($uuid);

        if ($pegadaian == 'empty') {
            return redirect(404);
        }

        $perpanjangan = Perpanjangan::where('uuid', '=', $uuid)->get();

        $data = [
            'pegadaian' => $pegadaian,
            'perpanjangan' => $perpanjangan,
        ];

        set_time_limit(300);

        $pdf = PDF::loadView('pages.dashboard.pdf', $data);

        return $pdf->download($uuid . ".pdf");
    }

    public function print($uuid)
    {
        $pegadaian = $this->report($uuid);

        if ($pegadaian == 'empty') {
            return redirect(404);
        }
        // dd($pegadaian);
        $perpanjangan = Perpanjangan::where('uuid_pegadaian', '=', $uuid)->get();

        $data = [
            'pegadaian' => $pegadaian,
            'perpanjangan' => $perpanjangan,
            'print' => true
        ];

        return view('pages.dashboard.pdf', $data);
    }
}
