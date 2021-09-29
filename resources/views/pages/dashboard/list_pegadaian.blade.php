@extends('app')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        List Pegadaian
        <small>List Pegadaian</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">List Pegadaian</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">List Pegadaian</h3>
        </div>
        <div class="box-body">
            <button style="float: right;" type="button" class="btn btn-sm btn-success btn-flat btn-add"><i class="fa fa-plus"></i> Tambah</button>
            <br />
            <br />
            <table id="pegadaian" url="{{ route('pegadaian.datatables') }}" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th data-column="DT_RowIndex" data-searchable="false" data-orderable="false">No</th>
                        <th data-column="nik_peminjam" data-searchable="true" data-orderable="true">NIK Peminjam</th>
                        <th data-column="nama_peminjam" data-searchable="true" data-orderable="true">Nama Peminjam</th>
                        <th data-column="alamat_peminjam" data-searchable="true" data-orderable="true">Alamat Peminjam</th>
                        <th data-column="no_telepon" data-searchable="true" data-orderable="true">No Telepon Peminjam</th>
                        <th data-column="tanggal_masuk_pinjaman" data-searchable="true" data-orderable="true">Tanggal Peminjaman</th>
                        <th data-column="tanggal_jatuh_tempo" data-searchable="true" data-orderable="true">Tanggal Jatuh Tempo</th>
                        <th data-column="jumlah_pinjaman" data-searchable="true" data-orderable="true">Jumlah Pinjaman</th>
                        <th data-column="jumlah_tebusan" data-searchable="true" data-orderable="true">Jumlah Tebusan</th>
                        <th data-column="keterangan_jaminan" data-searchable="true" data-orderable="true">Keterangan Jaminan</th>
                        <th data-column="status" data-searchable="true" data-orderable="true">Status Jaminan</th>
                        <th data-column="created_at" data-searchable="true" data-orderable="true">Diinput Pada</th>
                        <th data-column="tebus" data-searchable="false" data-orderable="false">Tebus</th>
                        <th data-column="perpanjang" data-searchable="false" data-orderable="false">Perpanjang</th>
                        <th data-column="lelang" data-searchable="false" data-orderable="false">Lelang</th>
                        <th data-column="view" data-searchable="false" data-orderable="false">Lihat</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>NIK Peminjam</th>
                        <th>Nama Peminjam</th>
                        <th>No Telepon Peminjam</th>
                        <th>Alamat Peminjam</th>
                        <th>Tanggal Peminjaman</th>
                        <th>Tanggal Jatuh Tempo</th>
                        <th>Jumlah Pinjaman</th>
                        <th>Jumlah Tebusan</th>
                        <th>Keterangan Jaminan</th>
                        <th>Status Jaminan</th>
                        <th>Diinput Pada</th>
                        <th>Tebus</th>
                        <th>Perpanjang</th>
                        <th>Lelang</th>
                        <th>Lihat</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->

</section>
<!-- /.content -->

@php
    $modal_id = "modal_pegadaian";
    $modal_size = "lg";
    $modal_title = "Form Pegadaian";
@endphp

@include('include/modal')

@php
    $modal_id = "modal_perpanjangan";
    $modal_size = "sm";
    $modal_title = "Form Perpanjangan";
@endphp

@include('include/modal')

@push('script')
    <script>

        let _modal = $('#modal_pegadaian');
        let _modal_perpanjangan = $('#modal_perpanjangan');
        let _table = $('#pegadaian');

        $(document).ready(function() {
            DataTables(_table);
        });

        $(document).on('click', '.btn-add', function() {
            let _url = "{{ route('pegadaian.create') }}";
            getViewModal(_url, _modal);
        });

        $(document).on('click', '.perpanjang', function() {
            let _url = $(this).attr('url');
            getViewModal(_url, _modal_perpanjangan);
        });

        $(document).on('click', '.report', function () {
            let _url = $(this).attr('url');
            window.open(_url);
        });

        $(document).on('submit', 'form#pendaftar', function() {
            event.preventDefault();
            let _data = new FormData($(this)[0]);
            let _url = $(this).attr('action');
            send((data, xhr = null) => {
                if(data.status == 'success') {
                    SuccessNotif(data.messages);
                    _modal.modal('hide');
                    _table.DataTable().ajax.reload();
                } else if(data.status == 'failed') {
                    FailedNotif(data.messages);
                }
            } , _url, 'json', 'post', _data);
        });

        $(document).on('submit', 'form#perpanjang', function() {
            event.preventDefault();
            let _data = new FormData($(this)[0]);
            let _url = $(this).attr('action');
            send((data, xhr = null) => {
                if(data.status == 'success') {
                    SuccessNotif(data.messages);
                    _modal_perpanjangan.modal('hide');
                    _table.DataTable().ajax.reload();
                } else if(data.status == 'failed') {
                    FailedNotif(data.messages);
                }
            } , _url, 'json', 'post', _data);
        })

        $(document).on('click', '.tebus', function() {
            let _url = $(this).attr('url');
            Swal.fire({
                title: 'Apakah Anda Yakin Menebus Jaminan Ini ?',
                showCancelButton: true,
                confirmButtonText: `Tebus`,
                confirmButtonColor: '#d33',
                icon: 'question'
            }).then((result) => {
                if (result.value) {
                    send((data, xhr = null) => {
                        if (data.status == "success") {
                            Swal.fire("Sukses", data.messages, 'success');
                            _table.DataTable().ajax.reload();
                        }
                    }, _url, "json", "get");
                }
            });
        });

        $(document).on('click', '.lelang', function() {
            let _url = $(this).attr('url');
            Swal.fire({
                title: 'Apakah Anda Yakin Melelang Jaminan Ini ?',
                showCancelButton: true,
                confirmButtonText: `Lelang`,
                confirmButtonColor: '#d33',
                icon: 'question'
            }).then((result) => {
                if (result.value) {
                    send((data, xhr = null) => {
                        if (data.status == "success") {
                            Swal.fire("Sukses", data.messages, 'success');
                            _table.DataTable().ajax.reload();
                        }
                    }, _url, "json", "get");
                }
            });
        });

    </script>

@endpush

@endsection