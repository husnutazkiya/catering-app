@extends('layouts.app')

@section('styles')
<style>
    .success-card {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.07);
        padding: 35px 28px;
        margin-top: 15px;
        margin-bottom: 40px;
    }
    .check-icon-circle {
        width: 76px;
        height: 76px;
        background: #f7f2ec;
        color: #5a351b;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 38px;
        margin-bottom: 18px;
        border: 3px solid #dfcfbe;
    }
    .receipt-box {
        background: #f8fafc;
        border: 1.5px dashed #cbd5e1;
        border-radius: 12px;
        padding: 22px;
        margin: 25px auto 20px;
        text-align: left;
        max-width: 580px;
    }
    .receipt-header {
        border-bottom: 1px dashed #cbd5e1;
        padding-bottom: 14px;
        margin-bottom: 14px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .receipt-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 9px;
        font-size: 14px;
    }
    .receipt-row-title {
        color: #64748b;
    }
    .receipt-row-value {
        font-weight: 700;
        color: #1e293b;
    }
    .receipt-items-list {
        margin: 14px 0;
        padding-top: 12px;
        border-top: 1px dashed #cbd5e1;
        border-bottom: 1px dashed #cbd5e1;
        padding-bottom: 12px;
    }

    @media print {
        body * {
            visibility: hidden;
        }
        .receipt-box, .receipt-box * {
            visibility: visible;
        }
        .receipt-box {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            border: 1px solid #000;
        }
        .no-print {
            display: none !important;
        }
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            
            <div class="success-card text-center">
                {{-- Icon Sukses --}}
                <div class="check-icon-circle">
                    <i class="fa fa-check"></i>
                </div>

                <h2 style="font-weight: 800; color: #1e293b; margin: 0 0 6px 0; font-size: 26px;">
                    Pesanan Berhasil Dibuat!
                </h2>
                <p style="color: #64748b; font-size: 15px; margin-bottom: 10px;">
                    Terima kasih telah memesan di <strong>SEKA Warkop & Cafe</strong>.
                </p>

                @if (!empty($lastOrder))
                    {{-- Struk / Ringkasan Bukti Pemesanan --}}
                    <div class="receipt-box">
                        <div class="receipt-header">
                            <div>
                                <span style="font-size: 11px; text-transform: uppercase; font-weight: 800; color: #5a351b; letter-spacing: 1px;">
                                    SEKA WARKOP & CAFE
                                </span>
                                <h4 style="margin: 2px 0 0 0; font-weight: 800; color: #2c180e;">
                                    Bukti Pemesanan Meja
                                </h4>
                            </div>
                            <span class="label label-warning" style="font-size: 12px; padding: 6px 10px; border-radius: 6px;">
                                <i class="fa fa-clock-o"></i> Menunggu Konfirmasi Barista
                            </span>
                        </div>

                        <div class="receipt-row">
                            <span class="receipt-row-title">Nama Pemesan:</span>
                            <span class="receipt-row-value">{{ $lastOrder['customer_name'] }}</span>
                        </div>

                        <div class="receipt-row">
                            <span class="receipt-row-title">Tipe Pemesanan:</span>
                            <span class="receipt-row-value">
                                @if ($lastOrder['order_type'] == 'dine_in')
                                    <span class="badge" style="background-color: #5a351b; font-size: 12px;">
                                        <i class="fa fa-coffee"></i> Makan di Tempat ({{ $lastOrder['table_no'] ?: 'Meja' }})
                                    </span>
                                @elseif ($lastOrder['order_type'] == 'takeaway')
                                    <span class="badge" style="background-color: #2563eb; font-size: 12px;">
                                        <i class="fa fa-shopping-bag"></i> Bawa Pulang (Takeaway)
                                    </span>
                                @else
                                    <span class="badge" style="background-color: #f59e0b; font-size: 12px;">
                                        <i class="fa fa-truck"></i> Antar ke Alamat (Delivery)
                                    </span>
                                @endif
                            </span>
                        </div>

                        @if (!empty($lastOrder['customer_phone']) && $lastOrder['customer_phone'] != '-')
                            <div class="receipt-row">
                                <span class="receipt-row-title">No. WhatsApp / HP:</span>
                                <span class="receipt-row-value">{{ $lastOrder['customer_phone'] }}</span>
                            </div>
                        @endif

                        <div class="receipt-row">
                            <span class="receipt-row-title">Waktu Dipesan:</span>
                            <span class="receipt-row-value">{{ date('d M Y - H:i', strtotime($lastOrder['time'])) }}</span>
                        </div>

                        @if (!empty($lastOrder['address']) && $lastOrder['order_type'] == 'delivery')
                            <div class="receipt-row">
                                <span class="receipt-row-title">Alamat Kirim:</span>
                                <span class="receipt-row-value" style="text-align: right; max-width: 60%;">{{ $lastOrder['address'] }}</span>
                            </div>
                        @endif

                        {{-- Rincian Item yang Dipesan --}}
                        @if (!empty($lastOrder['items']))
                            <div class="receipt-items-list">
                                <div style="font-weight: 700; color: #475569; font-size: 13px; margin-bottom: 8px;">
                                    Menu yang Dipesan:
                                </div>
                                @foreach ($lastOrder['items'] as $it)
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 6px; font-size: 13px;">
                                        <div>
                                            <strong>{{ $it['qty'] }}x</strong> {{ $it['name'] }}
                                            @if (!empty($it['addons']))
                                                <div style="font-size: 11px; color: #2563eb; margin-left: 14px;">
                                                    @foreach ($it['addons'] as $ad)
                                                        + {{ $ad['name'] }} (Rp {{ number_format($ad['price'], 0, ',', '.') }})<br>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                        <span style="font-weight: 700; color: #1e293b;">
                                            Rp {{ number_format($it['subtotal'], 0, ',', '.') }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <div class="receipt-row" style="margin-top: 12px; align-items: center;">
                            <span style="font-size: 15px; font-weight: 800; color: #0f172a;">TOTAL PEMBAYARAN:</span>
                            <span style="font-size: 20px; font-weight: 800; color: #e67e22;">
                                Rp {{ number_format($lastOrder['grand_total'], 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    {{-- Informasi Ramah Tamu / Dine-in --}}
                    @if ($lastOrder['order_type'] == 'dine_in')
                        <div style="background: #f7f2ec; border: 1px solid #dfcfbe; border-radius: 8px; padding: 12px 18px; margin: 15px auto; max-width: 580px; font-size: 13px; color: #5a351b; text-align: left;">
                            <i class="fa fa-coffee text-primary" style="margin-right: 5px;"></i>
                            <strong>Makan/Minum di Tempat:</strong> Pesanan Anda telah diterima barista/dapur SEKA. Silakan duduk santai di <strong>{{ $lastOrder['table_no'] }}</strong>, pesanan akan segera diantar ke meja Anda.
                        </div>
                    @else
                        <div style="background: #eff6ff; border-radius: 8px; padding: 12px 18px; margin: 15px auto; max-width: 580px; font-size: 13px; color: #1e40af; text-align: left;">
                            <i class="fa fa-info-circle text-info" style="margin-right: 5px;"></i>
                            Pesanan Anda sedang dalam antrean tim SEKA Warkop & Cafe. Kami akan segera menyiapkan pesanan Anda.
                        </div>
                    @endif
                @else
                    <div style="margin: 25px 0;">
                        <p style="font-size: 15px; color: #475569;">
                            Pesanan Anda telah berhasil masuk ke sistem kami dan sedang menunggu verifikasi dari admin.
                        </p>
                    </div>
                @endif

                {{-- Tombol Navigasi --}}
                <div class="no-print" style="margin-top: 25px; display: flex; justify-content: center; gap: 12px; flex-wrap: wrap;">
                    <button onclick="window.print()" class="btn btn-default" style="font-weight: 600; padding: 10px 18px;">
                        <i class="fa fa-print"></i> Cetak Bukti Nota
                    </button>

                    @if (Auth::check())
                        <a href="{{ route('listOrder') }}" class="btn btn-primary" style="font-weight: 700; padding: 10px 20px;">
                            <i class="fa fa-list"></i> Lihat Riwayat Pesanan
                        </a>
                    @endif

                    <a href="{{ url('/home') }}" class="btn btn-sekalori" style="font-weight: 700; padding: 10px 22px;">
                        <i class="fa fa-cutlery"></i> Pesan Menu Lainnya
                    </a>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection
