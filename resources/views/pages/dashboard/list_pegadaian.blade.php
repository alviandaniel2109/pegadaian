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
                        <th data-column="id" data-searchable="true" data-orderable="true">Nomor Peminjaman</th>
                        <th data-column="nik_peminjam" data-searchable="true" data-orderable="true">NIK Peminjam</th>
                        <th data-column="nama_peminjam" data-searchable="true" data-orderable="true">Nama Peminjam</th>
                        <th data-column="alamat_peminjam" data-searchable="true" data-orderable="true">Alamat Peminjam</th>
                        <th data-column="no_telepon" data-searchable="true" data-orderable="true">No Telepon Peminjam</th>
                        <th data-column="tanggal_masuk_pinjaman" data-searchable="true" data-orderable="true">Tanggal Peminjaman</th>
                        <th data-column="tanggal_jatuh_tempo" data-searchable="true" data-orderable="true">Tanggal Jatuh Tempo</th>
                        <th data-column="tanggal_perpanjangan" data-searchable="false" data-orderable="false">Tanggal Perpanjangan</th>
                        <th data-column="tanggal_perpanjangan_jatuh_tempo" data-searchable="false" data-orderable="false">Tanggal Perpanjangan Jatuh Tempo</th>
                        <th data-column="jumlah_pinjaman" data-searchable="true" data-orderable="true">Jumlah Pinjaman</th>
                        <th data-column="jumlah_tebusan" data-searchable="true" data-orderable="true">Jumlah Tebusan</th>
                        <th data-column="keterangan_jaminan" data-searchable="true" data-orderable="true">Keterangan Jaminan</th>
                        <th data-column="denda" data-searchable="false" data-orderable="false">Denda</th>
                        <th data-column="status" data-searchable="true" data-orderable="true">Status Jaminan</th>
                        <th data-column="created_at" data-searchable="true" data-orderable="true">Diinput Pada</th>
                        <th data-column="action" data-searchable="false" data-orderable="false">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
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

        $(document).on('click', '.edit', function() {
            let _url = $(this).attr('url');
            getViewModal(_url, _modal);
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
                    $('.notif_count').html(data.count_notif);
                    $('.notif_jth').html('Ada ' + data.count_notif + ' Yang Jatuh Tempo');
                    $('.listNotif').html(data.html_notif);
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
                    $('.notif_count').html(data.count_notif);
                    $('.notif_jth').html('Ada ' + data.count_notif + ' Yang Jatuh Tempo');
                    $('.listNotif').html(data.html_notif);
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
                            $('.notif_count').html(data.count_notif);
                            $('.notif_jth').html('Ada ' + data.count_notif + ' Yang Jatuh Tempo');
                            $('.listNotif').html(data.html_notif);
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
                            $('.notif_count').html(data.count_notif);
                            $('.notif_jth').html('Ada ' + data.count_notif + ' Yang Jatuh Tempo');
                            $('.listNotif').html(data.html_notif);  
                        }
                    }, _url, "json", "get");
                }
            });
        });

        $(document).on('click', '.delete', function() {
            let _url = $(this).attr('url');
            Swal.fire({
                title: 'Apakah Anda Yakin Menghapus Data Ini ?',
                showCancelButton: true,
                confirmButtonText: `Hapus`,
                confirmButtonColor: '#d33',
                icon: 'question'
            }).then((result) => {
                if (result.value) {
                    send((data, xhr = null) => {
                        if (data.status == "success") {
                            Swal.fire("Sukses", data.messages, 'success');
                            _table.DataTable().ajax.reload();
                            $('.notif_count').html(data.count_notif);
                            $('.notif_jth').html('Ada ' + data.count_notif + ' Yang Jatuh Tempo');
                            $('.listNotif').html(data.html_notif);  
                        }
                    }, _url, "json", "delete");
                }
            });
        });

    </script>

@endpush

@endsection