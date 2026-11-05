<header class="main-header">
    <a href="{{ url('/admin') }}" class="logo">
        <span class="logo-mini"><b>S</b>K</span>
        <span class="logo-lg" style="display: flex; align-items: center; justify-content: center; height: 50px;">
            <img src="{{ asset('assets/pictures/logo-sekalori.jpg') }}" alt="Sekalori" style="height: 28px; border-radius: 3px; vertical-align: middle; margin-right: 8px;">
            <b>SEKALORI</b>
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
                        <i class="fa fa-external-link" style="margin-right: 4px;"></i> <span class="hidden-xs">Lihat Toko Customer</span>
                    </a>
                </li>
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ asset('assets/pictures/profile.jpg') }}" class="user-image" alt="User Image">
                        <span class="hidden-xs">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header" style="background-color: #22714e !important;">
                            <img src="{{ asset('assets/pictures/profile.jpg') }}" class="img-circle" alt="User Image">
                            <p>
                                {{ Auth::user()->name }}
                                <br><small>Admin Sekalori Catering</small>
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
