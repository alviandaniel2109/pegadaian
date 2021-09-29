<!DOCTYPE html>
<html>

<head>
    @include('source.meta')
</head>


<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="https://kursusmengemudiairlangga.com/">Kursus Mengemudi Airlangga</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Silahkan Login</p>

    <form action="{{ $action }}" id="form" method="post" enctype="multipart/form-data">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" name="username" placeholder="Username">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="password" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat"><i class = "fa fa-sign-in"></i> Masuk</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

@include('source.script')

<script>
    $(document).on('submit', 'form', function() {
        event.preventDefault();
        let _url = $(this).attr('action');
        let _data = new FormData($(this)[0]);
        send((data, xhr = null) => {
            if (data.status == "success") {
                SuccessNotif(data.messages);
                let _url = data.url;
                console.log(_url);
                setInterval(function() {
                    window.location.href = _url
                });
            } else if (data.status == "failed") {
                FailedNotif(data.messages);
            }
        }, _url, 'json', 'post', _data)
    })
</script>

</body>
</html>