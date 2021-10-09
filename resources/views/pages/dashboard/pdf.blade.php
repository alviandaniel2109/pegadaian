<!DOCTYPE html>
<html>

<head>
    @include('source.meta')
</head>

<body>
    <div class="wrapper">

        @if(!empty($button))
        <br />
        <br />
        &nbsp;<a href="{{ $print_link }}" target="_blank"><button type="button" class="download btn-lg btn-flat btn-primary"><i class="fa fa-print"></i> Cetak PDF</button></a> &nbsp;
        <a href="{{ $button }}" target="_blank"><button type="button" class="download btn-lg btn-flat btn-warning"><i class="fa fa-download"></i> Unduh PDF</button></a>
        @endif

        <center><img src="{{ url('assets') }}/logo.png" width="500"></center>

        <br />

        <!-- Content Wrapper. Contains page content -->
        <!-- <div class="content-wrapper"> -->
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td>Nomor Peminjaman :</td>
                    <th>{{ $pegadaian['id'] }}</th>
                </tr>
                <tr>
                    <td>NIK Pendaftar :</td>
                    <th>{{ $pegadaian['nik_peminjam'] }}</th>
                </tr>
                <tr>
                    <td>Nama Peminjamn :</td>
                    <th>{{ $pegadaian['nama_peminjam'] }}</th>
                </tr>
                <tr>
                    <td>Alamat Peminjam :</td>
                    <th>{{ $pegadaian['alamat_peminjam'] }}</th>
                </tr>
                <tr>
                    <td>Nomor Telepon Peminjam :</td>
                    <th>{{ $pegadaian['no_telepon'] }}</th>
                </tr>
                <tr>
                    <td>Tanggal Masuk Pinjaman :</td>
                    <th>{{ $pegadaian['tanggal_masuk_pinjaman'] }}</th>
                </tr>
                <tr>
                    <td>Tanggal Jatuh Tempo :</td>
                    <th>{{ $pegadaian['tanggal_jatuh_tempo'] }}</th>
                </tr>
                <tr>
                    <td>Jaminan Tebusan :</td>
                    <th>{{ $pegadaian['keterangan_jaminan'] }}</th>
                </tr>
                <tr>
                    <td>Jumlah Pinjaman :</td>
                    <th>Rp. {{ number_format($pegadaian['jumlah_pinjaman']) }}</th>
                </tr>
                <tr>
                    <td>Jumlah Tebusan :</td>
                    <th>Rp. {{ number_format($pegadaian['jumlah_tebusan']) }}</th>
                </tr>
                @if($pegadaian['telat'] != 0)
                <tr>
                    <td>Jumlah Keterlambatan Hari :</td>
                    <th>{{ $pegadaian['telat'] }}</th>
                </tr>
                <tr>
                    <td>Jumlah Denda :</td>
                    <th>Rp. {{ number_format($pegadaian['denda']) }}</th>
                </tr>
                @endif
                @php
                $i = 0
                @endphp
                @if(count($perpanjangan) > 0)
                @foreach($perpanjangan as $perpanjangans)
                <tr>
                    <td>Perpanjangan Tgl - {{ $perpanjangans->tanggal_perpanjangan }}</td>
                    <th>{{ $perpanjangans->tanggal_perpanjangan_jatuh_tempo }}</th>
                </tr>
                @endforeach
                @endif
                <tr>
                    <td style="background-color : {{ $pegadaian['color'] }};">Status :</td>
                    <th style="background-color : {{ $pegadaian['color'] }};">{{ $pegadaian['status'] }}</th>
                </tr>
            </tbody>
        </table>
        <!-- </div> -->
    </div>
    
    @if(!empty($print))
        <script>
            window.print();
        </script>
    @endif    