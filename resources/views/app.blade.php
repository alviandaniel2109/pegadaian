<!DOCTYPE html>
<html>

<head>
    @include('source.meta')
</head>

</html>

<body class="hold-transition skin-red sidebar-mini">
    <div class="wrapper">
        <header class="main-header">
            @include('include.header')
        </header>

        <!-- Left side column. contains the sidebar -->
        <aside class="main-sidebar">
            @include('include.sidebar')
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>

        @include('include.footer')
    </div>

    @include('source.script')
</body>
</html>