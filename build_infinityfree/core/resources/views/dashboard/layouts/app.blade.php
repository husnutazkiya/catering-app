<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard</title>

    <link rel="shortcut icon" href="{{ asset('assets/pictures/logo.png') }}">

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('assets/dashboard/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/dashboard/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('assets/dashboard/bower_components/Ionicons/css/ionicons.min.css') }}">

    {{-- Aditional Style --}}
    @yield('style')

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dashboard/dist/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard/dist/css/skins/_all-skins.min.css') }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <style>
        /* Modern & Warm SEKA Warkop & Cafe Admin Theme */
        :root {
            --seka-brown: #5a351b;
            --seka-brown-dark: #432410;
            --seka-brown-hover: #331908;
            --seka-brown-light: #f7f2ec;
            --seka-caramel: #c58940;
            --seka-border: #dfcfbe;
        }

        /* Top Header Navbar */
        .skin-green-light .main-header .navbar,
        .skin-green .main-header .navbar {
            background-color: #5a351b !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        }
        .skin-green-light .main-header .logo,
        .skin-green .main-header .logo {
            background-color: #432410 !important;
            color: #ffffff !important;
            font-weight: 700;
            border-bottom: none;
        }
        .skin-green-light .main-header .logo:hover,
        .skin-green .main-header .logo:hover {
            background-color: #331908 !important;
        }
        .skin-green-light .main-header li.user-header {
            background-color: #5a351b !important;
        }

        /* Sidebar: Clean, Modern, Light */
        .skin-green-light .wrapper,
        .skin-green-light .main-sidebar,
        .skin-green-light .left-side {
            background-color: #ffffff !important;
            border-right: 1px solid #ebdccb;
        }
        .skin-green-light .sidebar-menu > li.header {
            background-color: #fcfaf8 !important;
            color: #785e4f !important;
            font-weight: 700;
            font-size: 11px;
            letter-spacing: 0.5px;
            padding: 12px 15px 8px;
        }
        .skin-green-light .sidebar-menu > li > a {
            color: #42291a !important;
            font-weight: 600;
            border-left: 3px solid transparent;
            padding: 12px 15px;
            transition: all 0.2s ease;
        }
        .skin-green-light .sidebar-menu > li:hover > a,
        .skin-green-light .sidebar-menu > li.active > a {
            color: #5a351b !important;
            background-color: #f7f2ec !important;
            border-left-color: #5a351b !important;
            font-weight: 700;
        }
        .skin-green-light .sidebar-menu .treeview-menu {
            background-color: #fcfaf8 !important;
        }
        .skin-green-light .sidebar-menu .treeview-menu > li.active > a,
        .skin-green-light .sidebar-menu .treeview-menu > li > a:hover {
            color: #5a351b !important;
            font-weight: 700;
        }

        /* Buttons & Accent Elements */
        .btn-primary, .btn-success {
            background-color: #5a351b !important;
            border-color: #4a2913 !important;
            color: #ffffff !important;
            border-radius: 4px;
            font-weight: 600;
            transition: all 0.2s ease;
        }
        .btn-primary:hover, .btn-primary:focus, .btn-primary:active,
        .btn-success:hover, .btn-success:focus, .btn-success:active {
            background-color: #432410 !important;
            border-color: #331908 !important;
            color: #ffffff !important;
            box-shadow: 0 4px 8px rgba(90, 53, 27, 0.28) !important;
        }

        /* Content & Cards */
        .content-wrapper {
            background-color: #fbf9f6 !important;
        }
        .content-header > h1 {
            color: #2c180e;
            font-weight: 700;
            font-size: 22px;
        }
        .box {
            border-radius: 8px !important;
            border-top: 3px solid #5a351b !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.04) !important;
            background: #ffffff;
            margin-bottom: 22px;
        }
        .box.box-primary {
            border-top-color: #5a351b !important;
        }
        .box-header.with-border {
            border-bottom: 1px solid #f2e8dc;
            padding: 14px 18px;
        }
        .box-header .box-title {
            font-weight: 700;
            color: #2c180e;
            font-size: 16px;
        }

        /* Stat Boxes */
        .small-box {
            border-radius: 10px !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06) !important;
            overflow: hidden;
            transition: transform 0.2s ease;
        }
        .small-box:hover {
            transform: translateY(-2px);
        }
        .small-box.bg-green {
            background-color: #5a351b !important;
        }
        .small-box.bg-aqua {
            background-color: #8c6239 !important;
        }
        .small-box.bg-yellow {
            background-color: #c58940 !important;
        }
        .small-box.bg-red {
            background-color: #a04028 !important;
        }

        /* Form Controls */
        .form-control:focus {
            border-color: #5a351b !important;
            box-shadow: 0 0 6px rgba(90, 53, 27, 0.25) !important;
        }

        /* Pagination */
        .pagination > .active > a, 
        .pagination > .active > span {
            background-color: #5a351b !important;
            border-color: #5a351b !important;
        }
    </style>

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">
        @include('dashboard.layouts.header')

        @include('dashboard.layouts.aside')

        @yield('content')

        @include('dashboard.layouts.footer')
    </div>

    <!-- jQuery 3 -->
    <script src="{{ asset('assets/dashboard/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ asset('assets/dashboard/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- Slimscroll -->
    <script src="{{ asset('assets/dashboard/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('assets/dashboard/bower_components/fastclick/lib/fastclick.js') }}"></script>

    {{-- Additional Script --}}
    @yield('scripts')

    <!-- AdminLTE App -->
    <script src="{{ asset('assets/dashboard/dist/js/adminlte.min.js') }}"></script>

    <script type="text/javascript">
        $("a[href='"+document.location+"']").parents('li').addClass('active')
    </script>
</body>
</html>
