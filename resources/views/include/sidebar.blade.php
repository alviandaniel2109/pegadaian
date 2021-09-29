<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
        <div class="pull-left image">
            <img src="{{ url('assets') }}/default.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
            <p>{{ Auth::user()->user_name }}</p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
    </div>
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li>
            <a href="{{ route('dashboard.index') }}">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            </a>
        </li>
        <li>
            <a href="{{ route('pegadaian.index') }}">
                <i class="fa fa-users"></i> <span>List Pegadaian</span>
            </a>
        </li>
    </ul>
</section>
<!-- /.sidebar -->

@push('script')
<script>
    let _menu = $('.sidebar-menu').find('a');
    for(var i = 0; i < _menu.length; i++) {
        href = _menu.eq(i).attr('href');
        if (window.location.href == href) {
            _menu.eq(i).parents('li').addClass('active');
            _menu.eq(i).parents('li').parents('li').addClass('active');
        }
    }
</script>
@endpush