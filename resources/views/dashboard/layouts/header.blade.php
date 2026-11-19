<header class="main-header">
    <a href="{{ url('/admin') }}" class="logo">
        <span class="logo-mini"><b>S</b>K</span>
        <span class="logo-lg" style="display: flex; align-items: center; justify-content: center; height: 50px;">
            <img src="{{ asset('assets/pictures/logo-seka.jpg') }}" alt="SEKA" style="height: 30px; width: 30px; object-fit: cover; border-radius: 50%; border: 1px solid rgba(255,255,255,0.4); vertical-align: middle; margin-right: 8px;">
            <b style="letter-spacing: 1.5px;">SEKA</b>
            <small style="font-size: 10px; opacity: 0.9; margin-left: 5px; font-weight: 600; letter-spacing: 1px;">WARKOP</small>
        </span>
    </a>

    <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li>
                    <a href="{{ url('/home') }}" target="_blank" title="Buka Halaman Customer">
                        <i class="fa fa-coffee" style="margin-right: 4px;"></i> <span class="hidden-xs">Lihat Menu Warkop</span>
                    </a>
                </li>
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ asset('assets/pictures/profile.jpg') }}" class="user-image" alt="User Image">
                        <span class="hidden-xs">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header" style="background-color: #5a351b !important;">
                            <img src="{{ asset('assets/pictures/profile.jpg') }}" class="img-circle" alt="User Image">
                            <p>
                                {{ Auth::user()->name }}
                                <br><small>Admin SEKA Warkop & Cafe</small>
                            </p>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{ url('/home') }}" class="btn btn-default btn-flat" target="_blank">Toko Customer</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('logout-admin') }}" class="btn btn-default btn-flat" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log out</a>
                            </div>
                            <form id="logout-form" action="{{ route('logout-admin') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
