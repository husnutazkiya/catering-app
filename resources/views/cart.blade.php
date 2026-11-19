@extends('layouts.app')

@section('styles')
<style>
    .cart-panel {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 14px rgba(0,0,0,0.06);
        padding: 24px;
        margin-bottom: 25px;
    }
    .cart-item-row {
        padding: 18px 0;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
    }
    .cart-item-row:last-child {
        border-bottom: none;
    }
    .cart-thumb {
        width: 90px;
        height: 75px;
        border-radius: 8px;
        object-fit: cover;
        margin-right: 18px;
        border: 1px solid #e2e8f0;
    }
    .summary-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 22px;
        position: sticky;
        top: 20px;
    }
</style>
@endsection

@section('content')
<div class="container" style="padding-top: 15px; padding-bottom: 50px;">
    
    <div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
        <div>
            <h2 style="font-weight: 800; color: #1e293b; margin: 0 0 6px 0;">
                <i class="fa fa-shopping-cart text-primary" style="margin-right: 10px;"></i>Keranjang Pemesanan
            </h2>
            <p style="color: #64748b; font-size: 14px; margin: 0;">
                Periksa daftar menu dan add-ons pilihan Anda sebelum melakukan konfirmasi pemesanan.
            </p>
        </div>
        <div style="margin-top: 10px;">
            <a href="{{ url('/home') }}" class="btn btn-default" style="font-weight: 600;">
                <i class="fa fa-plus-circle text-primary"></i> Tambah Menu Lainnya
            </a>
        </div>
    </div>

    {{-- Alert Messages --}}
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

    @if (!empty($cart) && count($cart) > 0)
        <div class="row">
            {{-- Kolom Kiri: Daftar Menu di Keranjang --}}
            <div class="col-md-7 col-lg-8">
                <div class="cart-panel">
                    <h4 style="font-weight: 700; color: #1e293b; margin-top: 0; padding-bottom: 12px; border-bottom: 2px solid #f1f5f9;">
                        Daftar Menu yang Dipesan ({{ count($cart) }} Item)
                    </h4>

                    <div class="cart-items-wrapper">
                        @foreach ($cart as $key => $item)
                            <div class="cart-item-row">
                                <div class="row" style="width: 100%; margin: 0;">
                                    {{-- Foto & Nama --}}
                                    <div class="col-xs-12 col-sm-6" style="display: flex; align-items: flex-start; padding: 0;">
                                        @if ($item['pict'] && file_exists(public_path('assets/pictures/menu/' . $item['pict'])))
                                            <img src="{{ asset('assets/pictures/menu/' . $item['pict']) }}" class="cart-thumb">
                                        @else
                                            <img src="{{ asset('assets/pictures/profile.jpg') }}" class="cart-thumb">
                                        @endif
                                        <div>
                                            <h4 style="font-weight: 700; color: #1e293b; margin: 0 0 5px 0;">
                                                {{ $item['name'] }}
                                            </h4>
                                            <div style="color: #64748b; font-size: 13px;">
                                                Harga Dasar: Rp {{ number_format($item['menu_price'], 0, ',', '.') }} / porsi
                                            </div>

                                            {{-- Rincian Add-ons yang dipilih --}}
                                            @if (!empty($item['addons']))
                                                <div style="margin-top: 6px;">
                                                    <span style="font-size: 12px; font-weight: 700; color: #2563eb;">
                                                        <i class="fa fa-plus-square"></i> Add-ons:
                                                    </span>
                                                    <ul style="margin: 2px 0 0 16px; padding: 0; font-size: 12px; color: #475569;">
                                                        @foreach ($item['addons'] as $addon)
                                                            <li>
                                                                {{ $addon['name'] }} 
                                                                <span class="text-warning" style="font-weight: 600;">(+Rp {{ number_format($addon['price'], 0, ',', '.') }})</span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Qty Controller --}}
                                    <div class="col-xs-7 col-sm-3 text-center" style="margin-top: 10px;">
                                        <form method="POST" action="{{ route('updateCart') }}" class="form-inline">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="key" value="{{ $key }}">
                                            <div class="input-group input-group-sm" style="width: 110px;">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" type="submit" name="qty" value="{{ max($item['qty'] - 1, $item['min_order']) }}">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                </span>
                                                <input type="text" class="form-control text-center" value="{{ $item['qty'] }}" readonly style="background: white; font-weight: 700;">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" type="submit" name="qty" value="{{ $item['qty'] + 1 }}">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </span>
                                            </div>
                                            <div style="font-size: 11px; color: #94a3b8; margin-top: 4px;">
                                                Min: {{ $item['min_order'] }} porsi
                                            </div>
                                        </form>
                                    </div>

                                    {{-- Subtotal & Hapus --}}
                                    <div class="col-xs-5 col-sm-3 text-right" style="margin-top: 10px; padding: 0;">
                                        <div style="font-size: 16px; font-weight: 800; color: #e67e22;">
                                            Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                        </div>
                                        <form method="POST" action="{{ route('removeFromCart') }}" style="margin-top: 6px;">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="key" value="{{ $key }}">
                                            <button type="submit" class="btn btn-link btn-xs text-danger" style="color: #ef4444; text-decoration: none;">
                                                <i class="fa fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div>
                    <a href="{{ url('/home') }}" class="btn btn-default" style="font-weight: 600;">
                        <i class="fa fa-arrow-left"></i> Kembali Pilih Menu Lainnya
                    </a>
                </div>
            </div>

            {{-- Kolom Kanan: Rincian Pengiriman & Penjumlahan Total Harga --}}
            <div class="col-md-5 col-lg-4">
                <div class="summary-card">
                    <h3 style="font-weight: 800; color: #0f172a; margin-top: 0; margin-bottom: 15px; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px;">
                        Ringkasan Pesanan
                    </h3>

                    <form method="POST" action="{{ route('checkoutCart') }}">
                        {{ csrf_field() }}

                        @if (session('table_no'))
                            <input type="hidden" name="table_no" value="{{ session('table_no') }}">
                            <div style="background: #f7f2ec; border: 1.5px solid #dfcfbe; border-radius: 8px; padding: 10px 14px; margin-bottom: 15px;">
                                <div style="font-size: 11px; font-weight: 700; color: #5a351b; text-transform: uppercase;">Lokasi Meja:</div>
                                <div style="font-size: 15px; font-weight: 800; color: #5a351b;">
                                    <i class="fa fa-coffee"></i> {{ session('table_no') }} (Makan / Minum di Tempat)
                                </div>
                            </div>
                        @endif

                        {{-- Identitas Pemesan (Bisa untuk Tamu Tanpa Login & Member) --}}
                        <div class="form-group">
                            <label style="font-weight: 700; font-size: 13px; color: #1e293b;">
                                <i class="fa fa-user text-primary"></i> Nama Pemesan:
                            </label>
                            <input type="text" name="customer_name" class="form-control" 
                                   value="{{ Auth::check() ? Auth::user()->name : '' }}" 
                                   placeholder="Masukkan nama Anda (misal: Budi / Meja {{ session('table_no') ? session('table_no') : '01' }})" required>
                        </div>

                        <div class="form-group">
                            <label style="font-weight: 700; font-size: 13px; color: #1e293b;">
                                <i class="fa fa-whatsapp text-success"></i> No. WhatsApp / HP (Opsional):
                            </label>
                            <input type="text" name="customer_phone" class="form-control" 
                                   value="{{ (Auth::check() && isset(Auth::user()->profile)) ? Auth::user()->profile->phone : '' }}" 
                                   placeholder="08123456789 (untuk notifikasi pesanan)">
                        </div>

                        {{-- Form Tipe Pesanan --}}
                        <div class="form-group">
                            <label style="font-weight: 700; color: #1e293b;">
                                <i class="fa fa-coffee text-primary"></i> Cara Pemesanan / Pengambilan:
                            </label>
                            <div>
                                @if (session('table_no'))
                                    <label class="radio" style="font-weight: normal; margin-bottom: 6px;">
                                        <input type="radio" name="order_type_option" value="dine_in" checked id="typeDineIn">
                                        <strong style="color: #5a351b;"><i class="fa fa-coffee"></i> Makan di Tempat ({{ session('table_no') }})</strong>
                                    </label>
                                    <label class="radio" style="font-weight: normal; margin-bottom: 6px;">
                                        <input type="radio" name="order_type_option" value="takeaway" id="typeTakeaway">
                                        <strong><i class="fa fa-shopping-bag"></i> Bungkus / Bawa Pulang (Takeaway)</strong>
                                    </label>
                                @else
                                    <label class="radio" style="font-weight: normal; margin-bottom: 6px;">
                                        <input type="radio" name="order_type_option" value="delivery" checked id="typeDelivery">
                                        <strong><i class="fa fa-truck"></i> Antarkan ke Alamat (Delivery)</strong>
                                    </label>
                                    <label class="radio" style="font-weight: normal; margin-bottom: 6px;">
                                        <input type="radio" name="order_type_option" value="takeaway" id="typeTakeaway">
                                        <strong><i class="fa fa-shopping-bag"></i> Ambil Sendiri di Toko Katering</strong>
                                    </label>
                                @endif
                                <input type="hidden" name="deliver" id="deliverInput" value="{{ session('table_no') ? '0' : '1' }}">
                            </div>
                        </div>

                        {{-- Tanggal dan Jam --}}
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label style="font-weight: 600; font-size: 13px;">Tanggal:</label>
                                    <input type="date" name="for_date" class="form-control" required value="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label style="font-weight: 600; font-size: 13px;">Jam:</label>
                                    <input type="time" name="for_time" class="form-control" required value="{{ date('H:i') }}">
                                </div>
                            </div>
                        </div>

                        {{-- Alamat Pengiriman (Hanya aktif jika Delivery) --}}
                        <div class="form-group" id="addressGroup" style="{{ session('table_no') ? 'display: none;' : '' }}">
                            <label style="font-weight: 600; font-size: 13px;">Alamat Pengantaran:</label>
                            <textarea name="to_addr" class="form-control" rows="3" placeholder="Masukkan alamat lengkap tujuan pengantaran...">{{ isset(Auth::user()->profile) ? Auth::user()->profile->address : '' }}</textarea>
                        </div>

                        <hr style="margin: 20px 0; border-color: #cbd5e1;">

                        {{-- Rincian Perhitungan Total --}}
                        <div style="margin-bottom: 15px;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                <span style="color: #64748b;">Subtotal ({{ count($cart) }} Menu):</span>
                                <span style="font-weight: 700; color: #1e293b;">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                <span style="color: #64748b;">Biaya Layanan & Kemasan:</span>
                                <span style="font-weight: 600; color: #10b981;">GRATIS</span>
                            </div>
                            <hr style="margin: 12px 0; border-color: #cbd5e1;">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span style="font-size: 16px; font-weight: 800; color: #0f172a;">TOTAL AKHIR:</span>
                                <span style="font-size: 24px; font-weight: 800; color: #e67e22;">
                                    Rp {{ number_format($total, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        {{-- Tombol Checkout --}}
                        <button type="submit" class="btn btn-sekalori btn-block btn-lg" 
                                style="font-weight: 800; border-radius: 8px; padding: 14px; font-size: 17px; box-shadow: 0 4px 12px rgba(34,113,78,0.35);">
                            <i class="fa fa-check-circle" style="margin-right: 6px;"></i> Konfirmasi & Buat Pesanan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @else
        <div class="cart-panel text-center" style="padding: 70px 20px;">
            <i class="fa fa-shopping-basket" style="font-size: 64px; color: #cbd5e1; margin-bottom: 18px;"></i>
            <h3 style="font-weight: 700; color: #475569; margin-bottom: 8px;">Keranjang Pemesanan Anda Kosong</h3>
            <p style="color: #94a3b8; font-size: 15px; margin-bottom: 25px;">
                Belum ada menu katering yang dimasukkan ke dalam keranjang.
            </p>
            <a href="{{ url('/home') }}" class="btn btn-primary btn-lg" style="font-weight: 700; border-radius: 8px; padding: 12px 30px;">
                <i class="fa fa-cutlery" style="margin-right: 8px;"></i> Mulai Pilih Menu Katering
            </a>
        </div>
    @endif

</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('input[name=order_type_option]').change(function() {
            var selected = $(this).val();
            if (selected === 'delivery') {
                $('#deliverInput').val('1');
                $('#addressGroup').slideDown();
            } else {
                $('#deliverInput').val('0');
                $('#addressGroup').slideUp();
            }
        });
    });
</script>
@endsection
