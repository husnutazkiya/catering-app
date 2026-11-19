@extends('layouts.app')

@section('styles')
<style>
    /* Grid Flexbox agar kartu sejajar dan tinggi sama rata */
    .menu-grid-row {
        display: flex;
        flex-wrap: wrap;
        margin-left: -8px;
        margin-right: -8px;
    }
    .menu-grid-col {
        padding-left: 8px;
        padding-right: 8px;
        margin-bottom: 16px;
        display: flex;
    }

    /* Kartu Menu Kompak */
    .menu-card-compact {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        transition: all 0.2s ease-in-out;
        width: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .menu-card-compact:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(34, 113, 78, 0.15);
        border-color: #22714e;
    }

    /* Area Gambar Menu */
    .menu-img-wrap {
        width: 100%;
        height: 150px;
        background-color: #f1f5f9;
        position: relative;
        overflow: hidden;
    }
    .menu-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .menu-card-compact:hover .menu-img {
        transform: scale(1.05);
    }

    /* Badge Minimal Order */
    .badge-min-order {
        position: absolute;
        bottom: 8px;
        left: 8px;
        background: rgba(15, 23, 42, 0.75);
        color: #ffffff;
        font-size: 10px;
        font-weight: 600;
        padding: 3px 7px;
        border-radius: 4px;
        backdrop-filter: blur(2px);
    }

    /* Konten Teks Kartu */
    .menu-card-body {
        padding: 12px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .menu-title {
        font-size: 15px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 6px 0;
        line-height: 1.35;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        height: 40px;
    }
    .menu-desc-short {
        font-size: 12px;
        color: #64748b;
        line-height: 1.4;
        margin-bottom: 8px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        height: 34px;
    }
    .menu-price-tag {
        font-size: 16px;
        font-weight: 800;
        color: #e67e22;
        margin-bottom: 8px;
    }
    .menu-price-tag span {
        font-size: 11px;
        font-weight: normal;
        color: #94a3b8;
    }
    .btn-detail-order {
        background-color: #22714e !important;
        border-color: #1b5b3f !important;
        color: #ffffff !important;
        border-radius: 6px;
        font-weight: 600;
        font-size: 13px;
        padding: 8px 10px;
        transition: all 0.2s ease-in-out;
    }
    .btn-detail-order:hover, 
    .btn-detail-order:focus, 
    .btn-detail-order:active {
        background-color: #185538 !important;
        border-color: #13452d !important;
        color: #ffffff !important;
        box-shadow: 0 4px 10px rgba(34, 113, 78, 0.3) !important;
    }

    /* Tab Pilihan Kategori (Makanan & Minuman) */
    .category-tabs-wrap {
        display: flex;
        gap: 10px;
        margin-bottom: 22px;
        overflow-x: auto;
        padding-bottom: 6px;
        -webkit-overflow-scrolling: touch;
    }
    .category-tab-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 20px;
        border-radius: 30px;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none !important;
        transition: all 0.2s ease-in-out;
        white-space: nowrap;
        border: 1.5px solid #e2e8f0;
        background: #f8fafc;
        color: #475569;
        cursor: pointer;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }
    .category-tab-btn:hover {
        background: #eaf5ee;
        border-color: #22714e;
        color: #22714e;
    }
    .category-tab-btn.active {
        background: #22714e !important;
        border-color: #22714e !important;
        color: #ffffff !important;
        box-shadow: 0 4px 14px rgba(34, 113, 78, 0.3) !important;
    }
    .category-tab-btn .tab-count {
        font-size: 11px;
        padding: 2px 7px;
        border-radius: 12px;
        background: #e2e8f0;
        color: #475569;
        font-weight: 800;
        transition: all 0.2s ease;
    }
    .category-tab-btn.active .tab-count {
        background: rgba(255, 255, 255, 0.28);
        color: #ffffff;
    }

    /* Badge Tag Kategori di Atas Gambar */
    .badge-cat-tag {
        position: absolute;
        top: 8px;
        right: 8px;
        font-size: 10px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 20px;
        letter-spacing: 0.3px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    }
    .badge-cat-makanan {
        background: rgba(34, 113, 78, 0.9);
        color: #ffffff;
    }
    .badge-cat-minuman {
        background: rgba(14, 116, 144, 0.9);
        color: #ffffff;
    }

    /* Penyesuaian Khusus Layar HP / Mobile (< 768px) */
    @media (max-width: 767px) {
        .menu-grid-row {
            margin-left: -5px;
            margin-right: -5px;
        }
        .menu-grid-col {
            padding-left: 5px;
            padding-right: 5px;
            margin-bottom: 10px;
        }
        .menu-img-wrap {
            height: 115px; /* Gambar lebih kompak di HP */
        }
        .menu-card-body {
            padding: 8px;
        }
        .menu-title {
            font-size: 13px;
            height: 35px;
            margin-bottom: 4px;
        }
        .menu-desc-short {
            display: none; /* Sembunyikan deskripsi panjang di HP agar kartu tetap ringkas */
        }
        .menu-price-tag {
            font-size: 13px;
            margin-bottom: 6px;
        }
        .badge-min-order {
            font-size: 9px;
            padding: 2px 5px;
            bottom: 5px;
            left: 5px;
        }
        .btn-detail-order {
            font-size: 11px;
            padding: 6px 6px;
        }
    }
</style>
@endsection

@section('content')
<div class="container" style="padding-top: 10px; padding-bottom: 40px;">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            
            {{-- Alert messages --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <i class="fa fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if (session('info'))
                <div class="alert alert-info alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <i class="fa fa-info-circle"></i> {{ session('info') }}
                </div>
            @endif

            {{-- Banner Mode Meja (Scan QR Code Tanpa Login) --}}
            @if (session('table_no'))
                <div style="background: linear-gradient(135deg, #eaf5ee 0%, #d8eee1 100%); border: 1.5px solid #22714e; border-radius: 12px; padding: 14px 18px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; box-shadow: 0 4px 12px rgba(34,113,78,0.12);">
                    <div style="display: flex; align-items: center; margin-bottom: 5px;">
                        <div style="background: #22714e; color: white; width: 42px; height: 42px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 20px; margin-right: 14px; flex-shrink: 0;">
                            <i class="fa fa-qrcode"></i>
                        </div>
                        <div>
                            <div style="font-size: 13px; color: #185538; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Mode Makan di Tempat (Dine-In)</div>
                            <div style="font-size: 16px; font-weight: 800; color: #1e293b;">
                                Anda memesan dari: <span style="background: #22714e; color: #ffffff; padding: 3px 10px; border-radius: 6px; font-size: 15px;">{{ session('table_no') }}</span>
                            </div>
                            <div style="font-size: 12px; color: #475569; margin-top: 2px;">
                                <i class="fa fa-check text-success"></i> Pesan langsung tanpa perlu login. Pesanan akan diantar ke meja Anda!
                            </div>
                        </div>
                    </div>
                    <div>
                        <a href="{{ url('/home?clear_table=1') }}" class="btn btn-default btn-sm" style="font-weight: 600; color: #ef4444; border-color: #cbd5e1; margin-top: 5px;">
                            <i class="fa fa-times-circle"></i> Ganti Meja / Mode Luar
                        </a>
                    </div>
                </div>
            @endif

            {{-- Header Title --}}
            <div style="margin-bottom: 16px; border-bottom: 2px solid #eaedf2; padding-bottom: 12px;">
                <h2 style="font-weight: 800; color: #1e293b; margin: 0 0 6px 0; font-size: 22px;">
                    <i class="fa fa-cutlery text-primary" style="margin-right: 8px;"></i>Daftar Menu Katering
                </h2>
                <p style="color: #64748b; font-size: 14px; margin: 0;">
                    Pilih menu favorit Anda dan klik untuk melihat detail lengkap serta pilihan add-ons.
                </p>
            </div>

            {{-- Tab Pilihan Kategori: Semua, Makanan, Minuman --}}
            <div class="category-tabs-wrap">
                <a href="{{ url('/home?' . http_build_query(array_merge(request()->except('page', 'category'), ['category' => 'all']))) }}" 
                   class="category-tab-btn {{ $activeCategory === 'all' ? 'active' : '' }}" 
                   data-cat="all">
                    <span>🍽️ Semua Menu</span>
                    <span class="tab-count">{{ $countAll }}</span>
                </a>
                
                <a href="{{ url('/home?' . http_build_query(array_merge(request()->except('page', 'category'), ['category' => 'makanan']))) }}" 
                   class="category-tab-btn {{ $activeCategory === 'makanan' ? 'active' : '' }}" 
                   data-cat="makanan">
                    <span>🍲 Makanan</span>
                    <span class="tab-count">{{ $countMakanan }}</span>
                </a>

                <a href="{{ url('/home?' . http_build_query(array_merge(request()->except('page', 'category'), ['category' => 'minuman']))) }}" 
                   class="category-tab-btn {{ $activeCategory === 'minuman' ? 'active' : '' }}" 
                   data-cat="minuman">
                    <span>🥤 Minuman</span>
                    <span class="tab-count">{{ $countMinuman }}</span>
                </a>
            </div>

            {{-- Grid Menu: 2 Kolom di HP (col-xs-6), 3 Kolom di Tablet/Desktop (col-sm-4 col-md-4) --}}
            @if ($menus->count() > 0)
                <div class="row menu-grid-row" id="menuGridContainer">
                    @foreach ($menus as $menu)
                        <div class="col-xs-6 col-sm-4 col-md-4 menu-grid-col" data-category="{{ $menu->category }}">
                            <div class="menu-card-compact">
                                {{-- Thumbnail Gambar --}}
                                <div class="menu-img-wrap">
                                    <a href="{{ route('getOrder', $menu->id) }}">
                                        @if ($menu->pict && file_exists(public_path('assets/pictures/menu/' . $menu->pict)))
                                            <img src="{{ asset('assets/pictures/menu/' . $menu->pict) }}" alt="{{ $menu->name }}" class="menu-img">
                                        @else
                                            <img src="{{ asset('assets/pictures/profile.jpg') }}" alt="{{ $menu->name }}" class="menu-img">
                                        @endif
                                    </a>
                                    
                                    {{-- Tag Kategori --}}
                                    @if ($menu->category === 'minuman')
                                        <span class="badge-cat-tag badge-cat-minuman"><i class="fa fa-glass"></i> Minuman</span>
                                    @else
                                        <span class="badge-cat-tag badge-cat-makanan"><i class="fa fa-cutlery"></i> Makanan</span>
                                    @endif

                                    <span class="badge-min-order">
                                        Min. {{ $menu->min_order }} porsi
                                    </span>
                                </div>

                                {{-- Informasi & Harga Menu --}}
                                <div class="menu-card-body">
                                    <div>
                                        <h3 class="menu-title">
                                            <a href="{{ route('getOrder', $menu->id) }}" style="color: inherit; text-decoration: none;">
                                                {{ $menu->name }}
                                            </a>
                                        </h3>
                                        <p class="menu-desc-short">
                                            {{ \Illuminate\Support\Str::limit($menu->description, 60) }}
                                        </p>
                                    </div>

                                    <div>
                                        <div class="menu-price-tag">
                                            Rp {{ number_format($menu->price, 0, ',', '.') }}
                                            <span>/porsi</span>
                                        </div>
                                        <a href="{{ route('getOrder', $menu->id) }}" class="btn btn-primary btn-block btn-detail-order">
                                            <span class="hidden-xs">Lihat Detail & Pesan</span>
                                            <span class="visible-xs-inline">Pesan <i class="fa fa-arrow-right"></i></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="text-center" style="margin-top: 15px;">
                    {{ $menus->links() }}
                </div>
            @else
                <div class="text-center" style="padding: 50px 20px; background: white; border-radius: 10px; border: 1px dashed #cbd5e1; margin-top: 15px;">
                    <i class="fa fa-cutlery" style="font-size: 42px; color: #cbd5e1; margin-bottom: 12px;"></i>
                    <h4 style="color: #64748b; font-weight: 700;">
                        @if ($activeCategory === 'minuman')
                            Belum Ada Menu Minuman
                        @elseif ($activeCategory === 'makanan')
                            Belum Ada Menu Makanan
                        @else
                            Belum Ada Menu Katering
                        @endif
                    </h4>
                    <p style="color: #94a3b8; font-size: 13px;">
                        @if ($activeCategory !== 'all')
                            Silakan pilih kategori lainnya atau lihat seluruh menu katering kami.
                        @else
                            Silakan tambahkan menu melalui dashboard admin atau seeder.
                        @endif
                    </p>
                    @if ($activeCategory !== 'all')
                        <a href="{{ url('/home' . (session('table_no') ? '?table='.urlencode(session('table_no')) : '')) }}" class="btn btn-primary btn-sm" style="margin-top: 8px;">
                            <i class="fa fa-th-large"></i> Lihat Semua Menu
                        </a>
                    @elseif (Auth::check() && Auth::user()->hasAdmin())
                        <a href="{{ route('all-menu') }}" class="btn btn-primary btn-sm" style="margin-top: 8px;">
                            <i class="fa fa-plus"></i> Tambah Menu di Admin
                        </a>
                    @endif
                </div>
            @endif

        </div>  
    </div>
</div>
@endsection
