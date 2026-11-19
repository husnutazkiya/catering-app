@extends('layouts.app')

@section('styles')
<style>
    .detail-panel {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 14px rgba(0,0,0,0.06);
        padding: 25px;
        margin-bottom: 30px;
    }
    .detail-img-wrap {
        border-radius: 10px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        max-height: 340px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .detail-img-wrap img {
        width: 100%;
        height: auto;
        object-fit: cover;
    }
    .addon-card {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 12px 16px;
        margin-bottom: 10px;
        background: #fafafa;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .addon-card:hover {
        background: #fdfbf8;
        border-color: #5a351b;
    }
    .addon-card.selected {
        background: #f7f2ec;
        border-color: #5a351b;
        box-shadow: 0 2px 6px rgba(90, 53, 27, 0.2);
    }
    .addon-checkbox {
        transform: scale(1.3);
        margin-right: 12px !important;
        cursor: pointer;
    }
    .price-summary-box {
        background: #f8fafc;
        border: 2px dashed #cbd5e1;
        border-radius: 10px;
        padding: 18px;
        margin-top: 20px;
    }
</style>
@endsection

@section('content')
<div class="container" style="padding-top: 15px; padding-bottom: 50px;">
    
    {{-- Breadcrumb & Table Indicator --}}
    <div style="margin-bottom: 18px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
        <a href="{{ url('/home') }}" class="btn btn-default btn-sm" style="font-weight: 600;">
            <i class="fa fa-arrow-left"></i> Kembali ke Daftar Menu
        </a>
        @if (session('table_no'))
            <span class="label" style="background-color: #5a351b; font-size: 13px; padding: 6px 12px; border-radius: 14px; margin-top: 5px;">
                <i class="fa fa-coffee"></i> Makan di Tempat: {{ session('table_no') }}
            </span>
        @endif
    </div>

    <form id="orderForm" method="POST" action="{{ route('addToCart') }}">
        {{ csrf_field() }}
        <input type="hidden" name="menu_id" value="{{ $menu->id }}">

        <div class="row">
            {{-- Kolom Kiri: Foto & Deskripsi --}}
            <div class="col-md-5">
                <div class="detail-panel">
                    <div class="detail-img-wrap">
                        @if ($menu->pict && file_exists(public_path('assets/pictures/menu/' . $menu->pict)))
                            <img src="{{ asset('assets/pictures/menu/' . $menu->pict) }}" alt="{{ $menu->name }}">
                        @else
                            <img src="{{ asset('assets/pictures/profile.jpg') }}" alt="{{ $menu->name }}">
                        @endif
                    </div>

                    <div style="margin-top: 20px;">
                        <h4 style="font-weight: 700; color: #1e293b; border-bottom: 2px solid #f1f5f9; padding-bottom: 8px;">
                            <i class="fa fa-info-circle text-primary"></i> Deskripsi Menu
                        </h4>
                        <p style="color: #475569; line-height: 1.7; font-size: 15px; margin-top: 12px;">
                            {{ $menu->description }}
                        </p>
                    </div>

                    <div style="margin-top: 20px; background: #f8fafc; padding: 15px; border-radius: 8px;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                            <span style="color: #64748b;"><i class="fa fa-users"></i> Minimal Pemesanan:</span>
                            <strong style="color: #1e293b;">{{ $menu->min_order }} Porsi</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: #64748b;"><i class="fa fa-shield"></i> Jaminan Mutu:</span>
                            <span class="text-success" style="font-weight: 600;"><i class="fa fa-check-circle"></i> Halal & Higienis</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Pilihan Menu, Add-ons & Jumlah --}}
            <div class="col-md-7">
                <div class="detail-panel">
                    <h2 style="font-weight: 800; color: #0f172a; margin-top: 0; margin-bottom: 10px;">
                        {{ $menu->name }}
                    </h2>
                    
                    <div style="font-size: 26px; font-weight: 800; color: #e67e22; margin-bottom: 20px;">
                        Rp {{ number_format($menu->price, 0, ',', '.') }}
                        <span style="font-size: 14px; font-weight: normal; color: #64748b;"> / Porsi</span>
                    </div>

                    <hr style="margin: 15px 0 25px 0; border-color: #e2e8f0;">

                    {{-- Bagian Pemilihan Add-ons --}}
                    <div>
                        <h4 style="font-weight: 700; color: #1e293b; margin-bottom: 6px;">
                            <i class="fa fa-plus-circle text-warning"></i> Pilih Add-ons (Menu Tambahan / Pelengkap)
                        </h4>
                        <p style="color: #64748b; font-size: 13px; margin-bottom: 15px;">
                            Centang item di bawah untuk menambahkan lauk / minuman pelengkap ke dalam porsi Anda:
                        </p>

                        <div class="addons-list">
                            @foreach ($addons as $addonKey => $addon)
                                <label class="addon-card" for="addon_{{ $addonKey }}">
                                    <div style="display: flex; align-items: center;">
                                        <input type="checkbox" name="addons[]" value="{{ $addonKey }}" id="addon_{{ $addonKey }}" 
                                               class="addon-checkbox addon-item" data-price="{{ $addon['price'] }}">
                                        <div>
                                            <div style="font-weight: 700; color: #1e293b; font-size: 14px;">
                                                <i class="fa {{ $addon['icon'] }} text-primary" style="margin-right: 4px;"></i> {{ $addon['name'] }}
                                            </div>
                                            <div style="color: #64748b; font-size: 12px;">{{ $addon['desc'] }}</div>
                                        </div>
                                    </div>
                                    <div style="font-weight: 700; color: #e67e22; font-size: 14px; white-space: nowrap; margin-left: 10px;">
                                        +Rp {{ number_format($addon['price'], 0, ',', '.') }}
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <hr style="margin: 25px 0; border-color: #e2e8f0;">

                    {{-- Jumlah Porsi (Qty) --}}
                    <div>
                        <label style="font-size: 16px; font-weight: 700; color: #1e293b; display: block; margin-bottom: 8px;">
                            <i class="fa fa-shopping-bag text-primary"></i> Jumlah Porsi yang Dipesan:
                        </label>
                        <div class="row">
                            <div class="col-xs-8 col-sm-6 col-md-5">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default btn-delQty" type="button" style="padding: 10px 16px; font-size: 16px;">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </span>
                                    <input type="number" name="qty" id="qtyInput" class="form-control" 
                                           value="{{ $menu->min_order }}" min="{{ $menu->min_order }}" 
                                           style="text-align: center; font-size: 18px; font-weight: 700; height: 46px; background-color: #ffffff;">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default btn-addQty" type="button" style="padding: 10px 16px; font-size: 16px;">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-7" style="padding-top: 10px;">
                                <span class="text-muted" style="font-size: 13px;">
                                    <i class="fa fa-info-circle text-info"></i> Minimal pemesanan menu ini: <strong>{{ $menu->min_order }} porsi</strong>
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Kotak Kalkulasi Total Harga --}}
                    <div class="price-summary-box">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                            <span style="color: #64748b;">Harga Satuan Menu:</span>
                            <span style="font-weight: 600;">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                            <span style="color: #64748b;">Tambahan Add-ons (Per Porsi):</span>
                            <span id="labelAddonsTotal" style="font-weight: 600; color: #2563eb;">+Rp 0</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                            <span style="color: #64748b;">Subtotal Per Porsi:</span>
                            <span id="labelPerPorsi" style="font-weight: 700; color: #1e293b;">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                            <span style="color: #64748b;">Jumlah Porsi (Qty):</span>
                            <span id="labelQty" style="font-weight: 700; color: #1e293b;">{{ $menu->min_order }} Porsi</span>
                        </div>
                        <hr style="margin: 10px 0; border-color: #cbd5e1;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-size: 16px; font-weight: 800; color: #0f172a;">TOTAL ESTIMASI:</span>
                            <span id="labelGrandTotal" style="font-size: 24px; font-weight: 800; color: #e67e22;">
                                Rp {{ number_format($menu->price * $menu->min_order, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="row" style="margin-top: 25px;">
                        <div class="col-sm-6" style="margin-bottom: 10px;">
                            <button type="submit" name="action" value="add_cart" class="btn btn-sekalori-outline btn-block btn-lg" 
                                    style="border-radius: 8px; padding: 12px;">
                                <i class="fa fa-shopping-cart" style="margin-right: 6px;"></i> Masukkan ke Keranjang
                            </button>
                        </div>
                        <div class="col-sm-6">
                            <button type="submit" name="action" value="direct_order" class="btn btn-sekalori btn-block btn-lg" 
                                    style="border-radius: 8px; padding: 12px;">
                                <i class="fa fa-arrow-circle-right" style="margin-right: 6px;"></i> Lanjut ke Keranjang
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        var basePrice = {{ $menu->price }};
        var minOrder = {{ $menu->min_order }};

        function formatRupiah(number) {
            return 'Rp ' + number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function calculateLiveTotal() {
            var qty = parseInt($('#qtyInput').val());
            if (isNaN(qty) || qty < minOrder) {
                qty = minOrder;
            }

            var addonsPerPortion = 0;
            $('.addon-item:checked').each(function() {
                addonsPerPortion += parseInt($(this).data('price'));
            });

            var pricePerPortion = basePrice + addonsPerPortion;
            var grandTotal = pricePerPortion * qty;

            $('#labelAddonsTotal').text('+Rp ' + addonsPerPortion.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
            $('#labelPerPorsi').text(formatRupiah(pricePerPortion));
            $('#labelQty').text(qty + ' Porsi');
            $('#labelGrandTotal').text(formatRupiah(grandTotal));
        }

        // Checkbox highlight toggle
        $('.addon-item').change(function() {
            if ($(this).is(':checked')) {
                $(this).closest('.addon-card').addClass('selected');
            } else {
                $(this).closest('.addon-card').removeClass('selected');
            }
            calculateLiveTotal();
        });

        // Add Qty Button
        $('.btn-addQty').click(function() {
            var currentQty = parseInt($('#qtyInput').val()) || minOrder;
            $('#qtyInput').val(currentQty + 1);
            calculateLiveTotal();
        });

        // Minus Qty Button
        $('.btn-delQty').click(function() {
            var currentQty = parseInt($('#qtyInput').val()) || minOrder;
            if (currentQty > minOrder) {
                $('#qtyInput').val(currentQty - 1);
                calculateLiveTotal();
            }
        });

        // Manual Input Change
        $('#qtyInput').on('input change', function() {
            var val = parseInt($(this).val());
            if (val < minOrder) {
                $(this).val(minOrder);
            }
            calculateLiveTotal();
        });

        // Run calculation once at startup
        calculateLiveTotal();
    });
</script>
@endsection
