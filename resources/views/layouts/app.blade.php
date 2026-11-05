<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="shortcut icon" href="{{ asset('assets/pictures/logo.png') }}">

    <!-- Styles -->
    {{-- <link href="/css/app.css" rel="stylesheet"> --}}
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="/css/style.css">
    {{-- Font-Awesome --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}">
    {{-- Additional Style --}}
    @yield('styles')

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image & Logo -->
                    <a class="navbar-brand" href="{{ url('/home') }}" style="display: flex; align-items: center; padding-top: 10px; padding-bottom: 10px;">
                        <img src="{{ asset('assets/pictures/logo-sekalori.jpg') }}" alt="Sekalori Logo" style="height: 30px; margin-right: 8px; border-radius: 4px; display: inline-block;">
                        <span style="color: #22714e; font-weight: 800; font-size: 18px; letter-spacing: 0.5px;">SEKALORI</span>
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    {{-- <ul class="nav navbar-nav">
                    </ul> --}}

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        @if (session('table_no'))
                            <li>
                                <a href="{{ url('/home') }}" style="color: #22714e; font-weight: 700;">
                                    <span class="label" style="background-color: #22714e; font-size: 12px; padding: 5px 10px; border-radius: 12px;">
                                        <i class="fa fa-cutlery"></i> {{ session('table_no') }}
                                    </span>
                                </a>
                            </li>
                        @endif

                        {{-- Keranjang Belanja (Dapat diakses Tamu Scan QR Meja & Member) --}}
                        @php $cartCount = session('cart') ? count(session('cart')) : 0; @endphp
                        <li>
                            <a href="{{ route('viewCart') }}">
                                <i class="fa fa-shopping-cart text-primary" aria-hidden="true" style="margin-right: 4px"></i> 
                                <strong>Keranjang</strong>
                                @if ($cartCount > 0)
                                    <span class="badge" style="background-color: #22714e; vertical-align: middle;">{{ $cartCount }}</span>
                                @endif
                            </a>
                        </li>

                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li>
                                <a href="{{ url('/login') }}">
                                    <i class="fa fa-sign-in"></i> Login Member
                                </a>
                            </li>
                            <li><a href="{{ url('/register') }}">Daftar</a></li>
                        @else
                            <li>
                                <a href="{{ route('listOrder') }}">
                                    <i class="fa fa-shopping-basket" aria-hidden="true" style="margin-right: 5px"></i> <strong>Pesanan</strong>
                                </a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    <i class="fa fa-user" aria-hidden="true" style="margin-right: 5px"></i> <strong>{{ explode(" ", Auth::user()->name)[0] }}</strong> 
                                    <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('/profile') }}">Lihat Profil</a>
                                        <a href="{{ url('/logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="/js/app.js"></script>

    {{-- Addisional Script --}}
    @yield('scripts')
</body>
</html>
