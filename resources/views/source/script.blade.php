<!-- jQuery 3 -->
<script src="{{ url('assets') }}/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ url('assets') }}/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="{{ url('assets') }}/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ url('assets') }}/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="{{ url('assets') }}/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="{{ url('assets') }}/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="{{ url('assets') }}/dist/js/adminlte.min.js"></script>
<!-- Select2 -->
<script src="{{ url('assets') }}/bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- InputMask -->
<script src="{{ url('assets') }}/plugins/input-mask/jquery.inputmask.js"></script>
<script src="{{ url('assets') }}/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="{{ url('assets') }}/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- date-range-picker -->
<script src="{{ url('assets') }}/bower_components/moment/min/moment.min.js"></script>
<script src="{{ url('assets') }}/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="{{ url('assets') }}/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap color picker -->
<script src="{{ url('assets') }}/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker -->
<script src="{{ url('assets') }}/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- SlimScroll -->
<script src="{{ url('assets') }}/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="{{ url('assets') }}/plugins/iCheck/icheck.min.js"></script>
<!-- PACE -->
<script src="{{ url('assets') }}/bower_components/PACE/pace.min.js"></script>
<!-- Toastr 2 -->
<script src="{{ url('assets') }}/bower_components/toastr/toastr.min.js"></script>
<!-- SweetAlert 2 -->
<script src="{{ url('assets') }}/bower_components/sweetalert2/sweetalert2.min.js"></script>
<!-- date-range-picker -->
<script src="{{ url('assets') }}/bower_components/moment/min/moment.min.js"></script>
<script src="{{ url('assets') }}/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="{{ url('assets') }}/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap color picker -->
<script src="{{ url('assets') }}/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker -->
<script src="{{ url('assets') }}/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- Main JS -->
<script src="{{ url('assets') }}/main.js"></script>
<script>
	$(document).ajaxStart(function() {
		Pace.restart()
	})
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
</script>
@stack('script')