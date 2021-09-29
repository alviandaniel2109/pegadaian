<meta charset="utf-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Aplikasi Pegadian</title>
<!-- Tell the browser to be responsive to screen width -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<link rel="icon" href="{{ url('assets') }}/favicon.png">
<!-- Bootstrap 3.3.7 -->
<link rel="stylesheet" href="{{ url('assets') }}/bower_components/bootstrap/dist/css/bootstrap.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ url('assets') }}/bower_components/font-awesome/css/font-awesome.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="{{ url('assets') }}/bower_components/Ionicons/css/ionicons.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="{{ url('assets') }}/bower_components/select2/dist/css/select2.min.css">
<!-- daterange picker -->
<link rel="stylesheet" href="{{ url('assets') }}/bower_components/bootstrap-daterangepicker/daterangepicker.css">
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{ url('assets') }}/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="{{ url('assets') }}/plugins/iCheck/all.css">
<!-- Bootstrap Color Picker -->
<link rel="stylesheet" href="{{ url('assets') }}/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
<!-- Bootstrap time Picker -->
<link rel="stylesheet" href="{{ url('assets') }}/plugins/timepicker/bootstrap-timepicker.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="{{ url('assets') }}/dist/css/AdminLTE.min.css">
<!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
<link rel="stylesheet" href="{{ url('assets') }}/dist/css/skins/_all-skins.min.css">
<!-- bootstrap wysihtml5 - text editor -->
<link rel="stylesheet" href="{{ url('assets') }}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{ url('assets') }}/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="{{ url('assets') }}/plugins/iCheck/all.css">
<!-- Bootstrap Color Picker -->
<link rel="stylesheet" href="{{ url('assets') }}/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
<!-- Bootstrap time Picker -->
<link rel="stylesheet" href="{{ url('assets') }}/plugins/timepicker/bootstrap-timepicker.min.css">
<!-- DataTables -->
<link rel="stylesheet" href="{{ url('assets') }}/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<!-- Pace style -->
<link rel="stylesheet" href="{{ url('assets') }}/plugins/pace/pace.min.css">
<!-- SweetAlert 2 -->
<link rel="stylesheet" href="{{ url('assets') }}/bower_components/sweetalert2/sweetalert2.min.css">
<!-- Toastr -->
<link rel="stylesheet" href="{{ url('assets') }}/bower_components/toastr/toastr.min.css">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

<!-- Google Font -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

@stack('style')