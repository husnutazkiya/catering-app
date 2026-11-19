<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header" style="font-size: 11px; letter-spacing: 0.5px; color: #64748b; padding: 14px 15px 8px;">NAVIGASI UTAMA</li>
            
            <li class="{{ Request::is('admin') ? 'active' : '' }}">
                <a href="{{ url('/admin') }}">
                    <i class="fa fa-dashboard text-primary"></i> <span>Dashboard</span>
                </a>
            </li>

            <li class="treeview {{ Request::is('admin/order*') ? 'active menu-open' : '' }}">
                <a href="#">
                    <i class="fa fa-shopping-basket text-primary"></i> <span>Kelola Pesanan</span>
                    <span class="pull-right-container">
                        @if ($count0 != 0)
                            <span class="label label-warning pull-right" style="border-radius: 10px;">{{ $count0 }} baru</span>
                        @else
                            <i class="fa fa-angle-left pull-right"></i>
                        @endif
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is('admin/order/pending') ? 'active' : '' }}">
                        <a href="{{ route('pending-order') }}">
                            <i class="fa fa-clock-o text-warning"></i> Pesanan Pending
                            @if ($count0 != 0)
                                <span class="label label-warning pull-right" style="border-radius: 10px;">{{ $count0 }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="{{ Request::is('admin/order/all') ? 'active' : '' }}">
                        <a href="{{ route('all-order') }}">
                            <i class="fa fa-check-circle text-success"></i> Semua Pesanan Selesai
                        </a>
                    </li>
                </ul>
            </li>

            <li class="{{ Request::is('admin/food-menu*') ? 'active' : '' }}">
                <a href="{{ route('food-menu.index') }}">
                    <i class="fa fa-cutlery text-primary"></i> <span>Kelola Menu Katering</span>
                </a>
            </li>

            <li class="{{ Request::is('admin/tables-qr*') ? 'active' : '' }}">
                <a href="{{ route('tablesQr') }}">
                    <i class="fa fa-qrcode text-success"></i> <span>QR Code Meja (Dine-in)</span>
                </a>
            </li>

            <li class="{{ Request::is('admin/customer*') ? 'active' : '' }}">
                <a href="{{ route('customer.index') }}">
                    <i class="fa fa-users text-primary"></i> <span>Data Pelanggan</span>
                </a>
            </li>

            <li class="header" style="font-size: 11px; letter-spacing: 0.5px; color: #64748b; padding: 18px 15px 8px;">AKSES PENGGUNA</li>

            <li>
                <a href="{{ url('/home') }}" target="_blank">
                    <i class="fa fa-external-link text-success"></i> <span>Halaman Depan (Toko)</span>
                </a>
            </li>

            <li>
                <a href="{{ route('logout-admin') }}" onclick="event.preventDefault(); document.getElementById('logout-aside-form').submit();">
                    <i class="fa fa-sign-out text-danger"></i> <span>Keluar / Logout</span>
                </a>
                <form id="logout-aside-form" action="{{ route('logout-admin') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        </ul>
    </section>
</aside>
