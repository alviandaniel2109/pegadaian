<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Kursus Mengemudi Airlangga">
    <meta name="author" content="Kursus Mengemudi Airlangga">
    <meta name="keywords" content="Kursus Mengemudi Airlangga">

    <!-- Title Page-->
    <title>Kursus Mengemudi Airlangga</title>

    <!-- Icons font CSS-->
    <link href="{{ url('assets') }}/register_form/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="{{ url('assets') }}/register_form/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <!-- Font special for pages-->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">

    <!-- Vendor CSS-->
    <link href="{{ url('assets') }}/register_form/vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="{{ url('assets') }}/register_form/vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="{{ url('assets') }}/register_form/css/main.css" rel="stylesheet" media="all">

    <!-- SweetAlert 2 -->
    <link rel="stylesheet" href="{{ url('assets') }}/bower_components/sweetalert2/sweetalert2.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ url('assets') }}/bower_components/toastr/toastr.min.css">

    <link rel="icon" href="{{ url('assets') }}/favicon.png">
</head>

<body>
    <div class="page-wrapper bg-blue p-t-180 p-b-100 font-robo">
        <div class="wrapper wrapper--w960">
            <div class="card card-2">
                <div class="card-heading"></div>
                <div class="card-body">
                    <h2 class="title">Silahkan Untuk Mendaftar</h2>
                    <form id="form" action="{{ $action }}" method="POST" enctype="multipart/form-data">
                        <div class="input-group">
                            <input class="input--style-2" type="text" placeholder="NIK KTP" name="nik_ktp" maxlength="16">
                        </div>
                        <div class="input-group">
                            <input class="input--style-2" type="text" placeholder="Nama Pendaftar" name="name">
                        </div>
                        <div class="input-group">
                            <input class="input--style-2" type="text" placeholder="Alamat Pendaftar" name="alamat">
                        </div>
                        <div class="input-group">
                            <input class="input--style-2" type="text" placeholder="Nomor Telepon/WA Pendaftar" name="nomor_telepon">
                        </div>
                        <div class="input-group">
                                    <div class="rs-select2 js-select-simple select--no-search">
                                        <select name="package">
                                            <option disabled="disabled" selected="selected">Pilih Paket</option>
                                            @foreach($training_packages as $key => $value)
                                                <option value="{{ $value['uuid'] }}">{{ $value['jenis_paket'] }} - {{ $value['nama_paket'] }} - {{ $value['waktu_paket'] }} - Rp. {{ number_format($value['biaya_paket']) }}</option>
                                            @endforeach
                                        </select>
                                        <div class="select-dropdown"></div>
                                    </div>
                                </div>
                        <div class="input-group">
                            <input class="input--style-2" type="file" placeholder="foto_ktp" name="foto_ktp">
                            <label for="fileupload">Upload Foto KTP</label>
                        </div>
                        <div class="p-t-30">
                            <button class="btn btn--radius btn--green" type="submit">Daftar</button>
                            <button class="btn btn--radius btn--yellow" type="reset">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery JS-->
    <script src="{{ url('assets') }}/register_form/vendor/jquery/jquery.min.js"></script>
    <!-- Vendor JS-->
    <script src="{{ url('assets') }}/register_form/vendor/select2/select2.min.js"></script>
    <script src="{{ url('assets') }}/register_form/vendor/datepicker/moment.min.js"></script>
    <script src="{{ url('assets') }}/register_form/vendor/datepicker/daterangepicker.js"></script>

    <!-- Toastr 2 -->
    <script src="{{ url('assets') }}/bower_components/toastr/toastr.min.js"></script>
    <!-- SweetAlert 2 -->
    <script src="{{ url('assets') }}/bower_components/sweetalert2/sweetalert2.min.js"></script>

    <!-- Main JS-->
    <script src="{{ url('assets') }}/register_form/js/global.js"></script>

    <!-- Main JS -->
    <script src="{{ url('assets') }}/main.js"></script>

    <script>
        $.ajaxSetup({
		    headers: {
			    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    	}
	    });
        $(document).on('submit', 'form', function() {
            event.preventDefault();
            let _data = new FormData($(this)[0]);
            let _url = $(this).attr('action');
            Swal.fire({
                title: 'Apakah Data Yang Dimasukkan Sudah Benar ?',
                showCancelButton: true,
                confirmButtonText: `Daftar`,
                confirmButtonColor: '#0000FF',
                icon: 'question'
        }).then((result) => {
            send((data, xhr = null) => {
                if(data.status == 'success') {
                    $(this)[0].reset();
                    Swal.fire({
                        type: 'success',
                        title: "Pendaftaran Sukses",
                        text: "Silahkan Untuk Menunggu Unduhan PDF Bukti Pendaftaran Anda",
                        timer: 3000,
                        icon: 'success',
                        showCancelButton: false,
                        showConfirmButton: false
                    }).then(function() {
                        window.location.href = data.url_report;
                    });
                } else if(data.status == 'failed') {
                    FailedNotif(data.messages);
                }
            }, _url, "json", "post", _data);
        });
            
        });
    </script>

</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>
<!-- end document-->