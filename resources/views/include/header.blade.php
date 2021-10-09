<!-- Logo -->
<a href="../../index2.html" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>KM</b>A</span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><img width="300" src="{{ url('assets') }}/logo.png"></span>
</a>
<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </a>

    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <!-- Messages: style can be found in dropdown.less-->
            <!-- Notifications: style can be found in dropdown.less -->
            <!-- Tasks: style can be found in dropdown.less -->
            <!-- User Account: style can be found in dropdown.less -->
            <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning notif_count">{{ count($pegadaian) }}</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header notif_jth">Ada {{ count($pegadaian) }} Yang Jatuh Tempo</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu listNotif">
                  @foreach($pegadaian as $pegadaians)  
                  <li>
                    <a href="{{ route('pegadaian.getReport', $pegadaians->uuid) }}" target="_blank">
                      <i class="fa fa-users text-aqua"></i> {{ $pegadaians->nik_peminjam }} - {{ $pegadaians->nama_peminjam }}
                    </a>
                  </li>
                  @endforeach
                  <li>
                </ul>
              </li>
            </ul>
          </li>
          
            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <img src="{{ url('assets') }}/default.png" class="user-image" alt="User Image">
                    <span class="hidden-xs">{{ Auth::user()->user_name }}</span>
                </a>
                <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header">
                        <img src="{{ url('assets') }}/default.png" class="img-circle" alt="User Image">

                        <p>
                        {{ Auth::user()->user_name }}
                            <small></small>
                        </p>
                    </li>
                    <!-- Menu Body -->
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <!-- <div class="pull-right"> -->
                            <center><a href="#" action="{{ route('auth.logout') }}" class="btn btn-default btn-flat logout">Sign out</a></center>
                        <!-- </div> -->
                    </li>
                </ul>
            </li>
            <!-- Control Sidebar Toggle Button -->
            <li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
            </li>
        </ul>
    </div>
</nav>

@push('script')
<script>
    $(document).on('click', '.logout', function() {
        let _url = $(this).attr('action');
        Swal.fire({
            title: 'Apakah Anda Yakin Keluar Dari Sistem ?',
            showCancelButton: true,
            confirmButtonText: `Logout`,
            confirmButtonColor: '#d33',
            icon: 'question'
        }).then((result) => {
            send((data, xhr = null) => {
                Swal.fire({
                    type: 'success',
                    title: "Logout Sukses",
                    text: data.messages,
                    timer: 3000,
                    icon: 'success',
                    showCancelButton: false,
                    showConfirmButton: false
                }).then(function() {
                    window.location.href = data.url;
                });
            }, _url, 'json');
        })
    });
</script>
@endpush