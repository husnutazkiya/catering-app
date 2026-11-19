@extends('dashboard.layouts.app')

@section('style')
<style>
    /* Styling Kartu QR Standee */
    .qr-grid-row {
        display: flex;
        flex-wrap: wrap;
        margin-left: -10px;
        margin-right: -10px;
    }
    .qr-grid-col {
        padding-left: 10px;
        padding-right: 10px;
        margin-bottom: 25px;
    }
    .table-standee-card {
        background: #ffffff;
        border: 2px solid #5a351b;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(90, 53, 27, 0.12);
        text-align: center;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        position: relative;
    }
    .table-standee-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(90, 53, 27, 0.2);
    }
    .standee-header {
        background: #5a351b;
        color: #ffffff;
        padding: 16px 12px 12px;
    }
    .standee-brand {
        font-size: 13px;
        font-weight: 800;
        letter-spacing: 1px;
        text-transform: uppercase;
        margin-bottom: 4px;
        opacity: 0.95;
    }
    .standee-table-title {
        font-size: 24px;
        font-weight: 900;
        margin: 0;
        letter-spacing: 0.5px;
    }
    .standee-body {
        padding: 20px 15px 15px;
    }
    .standee-qr-frame {
        background: #ffffff;
        border: 2px dashed #dfcfbe;
        border-radius: 12px;
        display: inline-block;
        padding: 10px;
        margin-bottom: 12px;
    }
    .standee-qr-img {
        width: 170px;
        height: 170px;
        display: block;
    }
    .standee-badge {
        display: inline-block;
        background: #f7f2ec;
        color: #5a351b;
        font-weight: 700;
        font-size: 12px;
        padding: 5px 12px;
        border-radius: 20px;
        margin-bottom: 10px;
        border: 1px solid #dfcfbe;
    }
    .standee-hint {
        font-size: 12px;
        color: #64748b;
        line-height: 1.4;
        margin-bottom: 14px;
        padding: 0 10px;
    }
    .standee-footer {
        background: #f8fafc;
        border-top: 1px solid #f1f5f9;
        padding: 10px 14px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* Print Mode Khusus Meja Standee */
    @media print {
        body, .content-wrapper, .wrapper {
            background: #ffffff !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        .main-header, .main-sidebar, .content-header, .filter-box, .standee-footer, .no-print {
            display: none !important;
        }
        .content {
            padding: 0 !important;
            margin: 0 !important;
        }
        .qr-grid-row {
            display: block !important;
            page-break-inside: auto;
        }
        .qr-grid-col {
            width: 48% !important;
            float: left !important;
            display: inline-block !important;
            margin-bottom: 25px !important;
            page-break-inside: avoid !important;
        }
        .table-standee-card {
            box-shadow: none !important;
            border: 2px solid #5a351b !important;
        }
        .standee-header {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            background-color: #5a351b !important;
            color: #ffffff !important;
        }
    }
</style>
@endsection

@section('content')
<div class="content-wrapper">
    {{-- Header --}}
    <section class="content-header">
        <h1>
            <i class="fa fa-qrcode" style="color: #5a351b; margin-right: 6px;"></i> QR Code Meja Pelanggan
            <small>Cetak & tempatkan QR code di atas meja untuk pelanggan memesan tanpa login</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">QR Code Meja</li>
        </ol>
    </section>

    {{-- Content --}}
    <section class="content">

        {{-- Panel Panduan & Filter --}}
        <div class="box box-success filter-box" style="border-top-color: #5a351b;">
            <div class="box-body">
                <div class="row" style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap;">
                    <div class="col-md-7 col-sm-12" style="margin-bottom: 10px;">
                        <div style="display: flex; align-items: flex-start;">
                            <div style="background: #f7f2ec; color: #5a351b; width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 22px; margin-right: 14px; flex-shrink: 0; border: 1px solid #dfcfbe;">
                                <i class="fa fa-coffee"></i>
                            </div>
                            <div>
                                <h4 style="margin: 0 0 5px 0; font-weight: 700; color: #2c180e;">
                                    Cara Kerja Pemesanan Scan QR Meja
                                </h4>
                                <p style="color: #785e4f; font-size: 13px; margin: 0; line-height: 1.5;">
                                    Pelanggan di warkop & cafe cukup membuka kamera HP atau aplikasi scanner dan memindai QR code di mejanya. Menu digital akan langsung terbuka dengan nomor meja otomatis tersimpan, memungkinkan mereka memesan & kustomisasi pesanan tanpa perlu antre atau login.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5 col-sm-12 text-right" style="margin-bottom: 10px;">
                        <form method="GET" action="{{ route('tablesQr') }}" class="form-inline" style="display: inline-block; margin-right: 8px;">
                            <label style="font-weight: 600; font-size: 13px; margin-right: 6px;">Jumlah Meja:</label>
                            <select name="count" class="form-control input-sm" onchange="this.form.submit()" style="border-radius: 6px;">
                                <option value="6" {{ $totalTables == 6 ? 'selected' : '' }}>6 Meja</option>
                                <option value="10" {{ $totalTables == 10 ? 'selected' : '' }}>10 Meja</option>
                                <option value="12" {{ $totalTables == 12 ? 'selected' : '' }}>12 Meja (Standar)</option>
                                <option value="15" {{ $totalTables == 15 ? 'selected' : '' }}>15 Meja</option>
                                <option value="20" {{ $totalTables == 20 ? 'selected' : '' }}>20 Meja</option>
                                <option value="30" {{ $totalTables == 30 ? 'selected' : '' }}>30 Meja</option>
                            </select>
                        </form>

                        <button onclick="window.print()" class="btn btn-success" style="background-color: #5a351b; border-color: #432410; font-weight: 700; border-radius: 6px;">
                            <i class="fa fa-print" style="margin-right: 4px;"></i> Cetak Semua QR Meja
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Grid Kartu Standee QR --}}
        <div class="qr-grid-row">
            @foreach ($tables as $t)
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 qr-grid-col">
                    <div class="table-standee-card">
                        {{-- Header Standee --}}
                        <div class="standee-header">
                            <div class="standee-brand">SEKA WARKOP & CAFE</div>
                            <h2 class="standee-table-title">{{ $t['name'] }}</h2>
                        </div>

                        {{-- Body Standee --}}
                        <div class="standee-body">
                            <div class="standee-badge">
                                <i class="fa fa-coffee" style="font-size: 13px; margin-right: 3px;"></i> SCAN UNTUK PESAN
                            </div>

                            <div class="standee-qr-frame">
                                <img src="{{ $t['qr_image'] }}" alt="QR Code {{ $t['name'] }}" class="standee-qr-img">
                            </div>

                            <div class="standee-hint">
                                Arahkan kamera HP ke QR Code untuk melihat Menu Digital & Pesan Langsung Tanpa Antre
                            </div>
                        </div>

                        {{-- Footer Action --}}
                        <div class="standee-footer no-print">
                            <a href="{{ $t['url'] }}" target="_blank" class="btn btn-default btn-xs" style="font-weight: 600; color: #5a351b;">
                                <i class="fa fa-external-link"></i> Tes Buka URL
                            </a>
                            <span style="font-size: 11px; color: #94a3b8;">
                                Standee #{{ $t['id'] }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </section>
</div>
@endsection

