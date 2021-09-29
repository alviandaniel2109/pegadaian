<!DOCTYPE html>
<html>

<head>
    @include('source.meta')
</head>

<body>
    <div class="wrapper">

        @if(!empty($button))
            <br/>
            <br/>
            <button type="button" class="download btn-lg btn-flat btn-primary" onclick="window.open({{ $button }});"><i class = "fa fa-print"></i> Cetak PDF</button>
        @endif

        <center><img src="{{ url('assets') }}/logo.png" width="500"></center>

        <br/>

        <!-- Content Wrapper. Contains page content -->
        <!-- <div class="content-wrapper"> -->
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td>NIK Pendaftar :</td>
                        <th>{{ $pegadaian->nik_peminjam }}</th>
                    </tr>
                    <tr>
                        <td>Nama Peminjamn :</td>
                        <th>{{ $pegadaian->nama_peminjam }}</th>
                    </tr>
                    <tr>
                        <td>Alamat Peminjam :</td>
                        <th>{{ $pegadaian->alamat_peminjam }}</th>
                    </tr>
                    <tr>
                        <td>Nomor Telepon Peminjam :</td>
                        <th>{{ $pegadaian->no_telepon }}</th>
                    </tr>
                    <tr>
                        <td>Tanggal Masuk Pinjaman :</td>
                        <th>{{ $pegadaian->tanggal_masuk_pinjaman }}</th>
                    </tr>
                    <tr>
                        <td>Tanggal Jatuh Tempo :</td>
                        <th>{{ $pegadaian->tanggal_jatuh_tempo }}</th>
                    </tr>
                    <tr>
                        <td>Jumlah Pinjaman :</td>
                        <th>Rp. {{ number_format($pegadaian->jumlah_pinjaman) }}</th>
                    </tr>
                    <tr>
                        <td>Jumlah Tebusan :</td>
                        <th>Rp. {{ number_format($pegadaian->jumlah_tebusan) }}</th>
                    </tr>
                    <tr>
                        <td>Waktu Pendaftaran :</td>
                        <th>{{ $pegadaian->created_at }}</th>
                    </tr>
                </tbody>
            </table>
        <!-- </div> -->
    </div>