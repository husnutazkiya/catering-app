@extends('dashboard.layouts.app')

@section('style')
<style>
    /* Filter Bar Periode */
    .period-filter-bar {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 18px;
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        box-shadow: 0 2px 6px rgba(0,0,0,0.03);
    }
    .btn-period-pill {
        border-radius: 20px;
        padding: 6px 16px;
        font-weight: 600;
        font-size: 13px;
        margin-right: 6px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #475569;
        transition: all 0.2s;
    }
    .btn-period-pill:hover {
        background: #f1f5f9;
        border-color: #94a3b8;
        color: #1e293b;
    }
    .btn-period-pill.active {
        background: #5a351b !important;
        border-color: #432410 !important;
        color: #ffffff !important;
        box-shadow: 0 2px 6px rgba(90, 53, 27, 0.3);
    }

    /* Kartu Metrik Finansial */
    .stat-card-finance {
        background: #ffffff;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 12px rgba(0,0,0,0.04);
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .stat-card-finance:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    }
    .stat-card-icon {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }
    .stat-card-info h4 {
        margin: 0 0 5px 0;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
    }
    .stat-card-info .amount {
        font-size: 22px;
        font-weight: 800;
        margin: 0;
        line-height: 1.2;
    }
    .stat-card-info .sub-desc {
        font-size: 11px;
        color: #94a3b8;
        margin-top: 4px;
    }

    /* Varian Warna */
    .theme-green { color: #5a351b; }
    .bg-soft-green { background: #f7f2ec; color: #5a351b; }

    .theme-rose { color: #e11d48; }
    .bg-soft-rose { background: #ffe4e6; color: #e11d48; }

    .theme-blue { color: #0284c7; }
    .bg-soft-blue { background: #e0f2fe; color: #0284c7; }

    .theme-amber { color: #c58940; }
    .bg-soft-amber { background: #fdf6ec; color: #c58940; }

    /* List Belanja */
    .expense-item {
        padding: 12px 16px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: background 0.15s;
    }
    .expense-item:hover {
        background: #f8fafc;
    }
    .expense-item:last-child {
        border-bottom: none;
    }
    .badge-category {
        font-size: 10px;
        font-weight: 600;
        padding: 3px 7px;
        border-radius: 4px;
        background: #f1f5f9;
        color: #475569;
    }

    /* Tombol Toggle Grafik */
    .btn-chart-mode {
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
        padding: 4px 10px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #64748b;
    }
    .btn-chart-mode.active {
        background: #5a351b;
        border-color: #5a351b;
        color: #ffffff;
    }
</style>
@endsection

@section('content')
<div class="content-wrapper">
    {{-- Header Halaman --}}
    <section class="content-header" style="padding-top: 20px; padding-bottom: 12px;">
        <h1 style="font-weight: 800; color: #2c180e; margin: 0; font-size: 24px;">
            <i class="fa fa-dashboard" style="color: #5a351b; margin-right: 8px;"></i>Ringkasan Bisnis & Finansial
            <small style="font-size: 14px; color: #785e4f;">SEKA Warkop & Cafe</small>
        </h1>
    </section>

    <section class="content" style="padding-top: 5px;">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible" role="alert" style="border-radius: 8px;">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <i class="fa fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        {{-- BARIS FILTER PERIODE (HARI INI / MINGGU INI / BULAN INI / SEMUA WAKTU) --}}
        <div class="period-filter-bar">
            <div style="display: flex; align-items: center; margin-bottom: 6px;">
                <span style="font-weight: 700; color: #2c180e; margin-right: 12px; font-size: 14px;">
                    <i class="fa fa-filter" style="color: #5a351b;"></i> Periode Tinjauan:
                </span>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-period-pill active" data-period="today">
                        <i class="fa fa-calendar-check-o"></i> Hari Ini
                    </button>
                    <button type="button" class="btn btn-period-pill" data-period="week">
                        <i class="fa fa-calendar"></i> Minggu Ini
                    </button>
                    <button type="button" class="btn btn-period-pill" data-period="month">
                        <i class="fa fa-calendar-o"></i> Bulan Ini
                    </button>
                    <button type="button" class="btn btn-period-pill" data-period="all">
                        <i class="fa fa-database"></i> Semua Waktu
                    </button>
                </div>
            </div>
            <div style="margin-bottom: 6px;">
                <span id="periodLabelBadge" class="label" style="background-color: #f7f2ec; color: #5a351b; font-size: 12px; padding: 6px 12px; border-radius: 12px; font-weight: 700; border: 1px solid #dfcfbe;">
                    <i class="fa fa-clock-o"></i> {{ $financeStats['today']['label'] }}
                </span>
            </div>
        </div>

        {{-- BARIS KARTU METRIK FINANSIAL REALTIME --}}
        <div class="row">
            {{-- 1. Total Pendapatan Catering --}}
            <div class="col-lg-3 col-sm-6 col-xs-12">
                <div class="stat-card-finance">
                    <div class="stat-card-info">
                        <h4>Total Pendapatan</h4>
                        <div class="amount theme-green" id="cardRevenue">
                            Rp {{ number_format($financeStats['today']['revenue'], 0, ',', '.') }}
                        </div>
                        <div class="sub-desc" id="cardRevenueDesc">Pesanan masuk hari ini</div>
                    </div>
                    <div class="stat-card-icon bg-soft-green">
                        <i class="fa fa-money"></i>
                    </div>
                </div>
            </div>

            {{-- 2. Total Pengeluaran Belanja --}}
            <div class="col-lg-3 col-sm-6 col-xs-12">
                <div class="stat-card-finance">
                    <div class="stat-card-info">
                        <h4>Pengeluaran Belanja</h4>
                        <div class="amount theme-rose" id="cardExpense">
                            Rp {{ number_format($financeStats['today']['expense'], 0, ',', '.') }}
                        </div>
                        <div class="sub-desc" id="cardExpenseDesc">Belanja bahan baku hari ini</div>
                    </div>
                    <div class="stat-card-icon bg-soft-rose">
                        <i class="fa fa-shopping-basket"></i>
                    </div>
                </div>
            </div>

            {{-- 3. Total Keuntungan Bersih --}}
            <div class="col-lg-3 col-sm-6 col-xs-12">
                <div class="stat-card-finance">
                    <div class="stat-card-info">
                        <h4>Keuntungan Bersih</h4>
                        <div class="amount {{ $financeStats['today']['profit'] >= 0 ? 'theme-blue' : 'theme-rose' }}" id="cardProfit">
                            Rp {{ number_format($financeStats['today']['profit'], 0, ',', '.') }}
                        </div>
                        <div class="sub-desc" id="cardProfitDesc">Pendapatan dikurangi belanja</div>
                    </div>
                    <div class="stat-card-icon bg-soft-blue">
                        <i class="fa fa-line-chart"></i>
                    </div>
                </div>
            </div>

            {{-- 4. Jumlah Pesanan Masuk --}}
            <div class="col-lg-3 col-sm-6 col-xs-12">
                <div class="stat-card-finance">
                    <div class="stat-card-info">
                        <h4>Pesanan Masuk</h4>
                        <div class="amount theme-amber" id="cardOrders">
                            {{ $financeStats['today']['orders'] }} <span style="font-size: 13px; font-weight: normal; color: #64748b;">Pesanan</span>
                        </div>
                        <div class="sub-desc">Total transaksi pada periode ini</div>
                    </div>
                    <div class="stat-card-icon bg-soft-amber">
                        <i class="fa fa-cutlery"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- BARIS TABEL PERBANDINGAN PERIODE (HARI, MINGGU, BULAN, SEMUA WAKTU) --}}
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary" style="border-radius: 10px; overflow: hidden; margin-bottom: 22px;">
                    <div class="box-header with-border" style="padding: 14px 18px;">
                        <h3 class="box-title" style="font-weight: 700; font-size: 15px; color: #1e293b;">
                            <i class="fa fa-table text-primary" style="margin-right: 6px;"></i>Tabel Perbandingan Finansial (Per Hari, Per Minggu, Per Bulan, Semua Waktu)
                        </h3>
                    </div>
                    <div class="box-body no-padding table-responsive">
                        <table class="table table-striped table-hover" style="margin: 0; font-size: 13px;">
                            <thead>
                                <tr style="background: #f8fafc; color: #475569;">
                                    <th style="padding: 12px 16px;">Periode Perhitungan</th>
                                    <th style="padding: 12px 16px;">Keterangan Tanggal</th>
                                    <th style="padding: 12px 16px; text-align: right;">Total Pendapatan</th>
                                    <th style="padding: 12px 16px; text-align: right;">Pengeluaran Belanja</th>
                                    <th style="padding: 12px 16px; text-align: right;">Keuntungan Bersih</th>
                                    <th style="padding: 12px 16px; text-align: center;">Pesanan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding: 12px 16px; font-weight: 700; color: #1e293b;">
                                        <i class="fa fa-calendar-check-o text-primary" style="margin-right: 4px;"></i> Hari Ini
                                    </td>
                                    <td style="padding: 12px 16px; color: #64748b;">{{ $financeStats['today']['label'] }}</td>
                                    <td style="padding: 12px 16px; text-align: right; font-weight: 700; color: #22714e;">
                                        Rp {{ number_format($financeStats['today']['revenue'], 0, ',', '.') }}
                                    </td>
                                    <td style="padding: 12px 16px; text-align: right; font-weight: 700; color: #e11d48;">
                                        - Rp {{ number_format($financeStats['today']['expense'], 0, ',', '.') }}
                                    </td>
                                    <td style="padding: 12px 16px; text-align: right; font-weight: 800; color: {{ $financeStats['today']['profit'] >= 0 ? '#0284c7' : '#e11d48' }};">
                                        Rp {{ number_format($financeStats['today']['profit'], 0, ',', '.') }}
                                    </td>
                                    <td style="padding: 12px 16px; text-align: center;">
                                        <span class="badge" style="background-color: #22714e;">{{ $financeStats['today']['orders'] }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 16px; font-weight: 700; color: #1e293b;">
                                        <i class="fa fa-calendar text-info" style="margin-right: 4px;"></i> Minggu Ini
                                    </td>
                                    <td style="padding: 12px 16px; color: #64748b;">{{ $financeStats['week']['label'] }}</td>
                                    <td style="padding: 12px 16px; text-align: right; font-weight: 700; color: #22714e;">
                                        Rp {{ number_format($financeStats['week']['revenue'], 0, ',', '.') }}
                                    </td>
                                    <td style="padding: 12px 16px; text-align: right; font-weight: 700; color: #e11d48;">
                                        - Rp {{ number_format($financeStats['week']['expense'], 0, ',', '.') }}
                                    </td>
                                    <td style="padding: 12px 16px; text-align: right; font-weight: 800; color: {{ $financeStats['week']['profit'] >= 0 ? '#0284c7' : '#e11d48' }};">
                                        Rp {{ number_format($financeStats['week']['profit'], 0, ',', '.') }}
                                    </td>
                                    <td style="padding: 12px 16px; text-align: center;">
                                        <span class="badge" style="background-color: #0284c7;">{{ $financeStats['week']['orders'] }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 16px; font-weight: 700; color: #1e293b;">
                                        <i class="fa fa-calendar-o text-warning" style="margin-right: 4px;"></i> Bulan Ini
                                    </td>
                                    <td style="padding: 12px 16px; color: #64748b;">{{ $financeStats['month']['label'] }}</td>
                                    <td style="padding: 12px 16px; text-align: right; font-weight: 700; color: #22714e;">
                                        Rp {{ number_format($financeStats['month']['revenue'], 0, ',', '.') }}
                                    </td>
                                    <td style="padding: 12px 16px; text-align: right; font-weight: 700; color: #e11d48;">
                                        - Rp {{ number_format($financeStats['month']['expense'], 0, ',', '.') }}
                                    </td>
                                    <td style="padding: 12px 16px; text-align: right; font-weight: 800; color: {{ $financeStats['month']['profit'] >= 0 ? '#0284c7' : '#e11d48' }};">
                                        Rp {{ number_format($financeStats['month']['profit'], 0, ',', '.') }}
                                    </td>
                                    <td style="padding: 12px 16px; text-align: center;">
                                        <span class="badge" style="background-color: #d97706;">{{ $financeStats['month']['orders'] }}</span>
                                    </td>
                                </tr>
                                <tr style="background: #f8fafc;">
                                    <td style="padding: 12px 16px; font-weight: 800; color: #1e293b;">
                                        <i class="fa fa-database text-success" style="margin-right: 4px;"></i> Semua Waktu
                                    </td>
                                    <td style="padding: 12px 16px; color: #64748b;">Seluruh riwayat transaksi katering</td>
                                    <td style="padding: 12px 16px; text-align: right; font-weight: 800; color: #22714e;">
                                        Rp {{ number_format($financeStats['all']['revenue'], 0, ',', '.') }}
                                    </td>
                                    <td style="padding: 12px 16px; text-align: right; font-weight: 800; color: #e11d48;">
                                        - Rp {{ number_format($financeStats['all']['expense'], 0, ',', '.') }}
                                    </td>
                                    <td style="padding: 12px 16px; text-align: right; font-weight: 900; color: {{ $financeStats['all']['profit'] >= 0 ? '#0284c7' : '#e11d48' }};">
                                        Rp {{ number_format($financeStats['all']['profit'], 0, ',', '.') }}
                                    </td>
                                    <td style="padding: 12px 16px; text-align: center;">
                                        <span class="badge" style="background-color: #475569;">{{ $financeStats['all']['orders'] }}</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- BARIS GRAFIK & DAFTAR BELANJA TERBARU --}}
        <div class="row">
            {{-- KOLOM KIRI: GRAFIK DENGAN TOGGLE MODE (HARIAN / MINGGUAN / BULANAN) --}}
            <div class="col-lg-7 col-md-12">
                <div class="box box-primary" style="border-radius: 10px; overflow: hidden;">
                    <div class="box-header with-border" style="display: flex; justify-content: space-between; align-items: center; padding: 14px 18px; flex-wrap: wrap;">
                        <div>
                            <h3 class="box-title" style="font-weight: 700; font-size: 15px; color: #1e293b;">
                                <i class="fa fa-bar-chart text-primary" style="margin-right: 6px;"></i>Grafik Pendapatan & Pengeluaran
                            </h3>
                            <div style="font-size: 12px; color: #64748b; margin-top: 2px;" id="chartSubtitle">Tampilan Harian (7 Hari Terakhir)</div>
                        </div>
                        <div style="margin-top: 6px;">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-chart-mode active" data-mode="daily">Harian</button>
                                <button type="button" class="btn btn-chart-mode" data-mode="weekly">Mingguan</button>
                                <button type="button" class="btn btn-chart-mode" data-mode="monthly">Bulanan</button>
                            </div>
                        </div>
                    </div>
                    <div class="box-body" style="padding: 18px;">
                        <div style="position: relative; height: 320px; width: 100%;">
                            <canvas id="financeChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: DAFTAR BELANJA TERBARU --}}
            <div class="col-lg-5 col-md-12">
                <div class="box box-primary" style="border-radius: 10px; overflow: hidden;">
                    <div class="box-header with-border" style="display: flex; justify-content: space-between; align-items: center; padding: 14px 18px;">
                        <div>
                            <h3 class="box-title" style="font-weight: 700; font-size: 15px; color: #1e293b;">
                                <i class="fa fa-list-alt text-primary" style="margin-right: 6px;"></i>Daftar Belanja Terbaru
                            </h3>
                            <div style="font-size: 12px; color: #64748b; margin-top: 2px;">Catatan belanja bahan baku & modal</div>
                        </div>
                        <div>
                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalAddExpense" style="border-radius: 6px; font-weight: 600;">
                                <i class="fa fa-plus"></i> Catat Belanja
                            </button>
                        </div>
                    </div>
                    <div class="box-body" style="padding: 0;">
                        @if ($recentExpenses->count() > 0)
                            <div class="expense-list-container" style="max-height: 320px; overflow-y: auto;">
                                @foreach ($recentExpenses as $exp)
                                    <div class="expense-item">
                                        <div style="padding-right: 10px;">
                                            <div style="font-weight: 700; color: #1e293b; font-size: 13px; margin-bottom: 2px;">
                                                {{ $exp->title }}
                                            </div>
                                            <div style="display: flex; align-items: center; gap: 6px; flex-wrap: wrap;">
                                                <span class="badge-category">{{ $exp->category }}</span>
                                                <span style="font-size: 11px; color: #94a3b8;">
                                                    <i class="fa fa-calendar"></i> {{ date('d M Y', strtotime($exp->expense_date)) }}
                                                </span>
                                                @if ($exp->notes)
                                                    <span style="font-size: 11px; color: #64748b;">• {{ $exp->notes }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div style="text-align: right; white-space: nowrap;">
                                            <div style="font-weight: 800; color: #e11d48; font-size: 13px;">
                                                - Rp {{ number_format($exp->amount, 0, ',', '.') }}
                                            </div>
                                            <form action="{{ route('expense.destroy', $exp->id) }}" method="POST" style="display: inline-block; margin-top: 2px;" onsubmit="return confirm('Hapus catatan belanja ini?')">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button type="submit" class="btn btn-link btn-xs text-danger" style="padding: 0; color: #94a3b8;" title="Hapus">
                                                    <i class="fa fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center" style="padding: 40px 20px;">
                                <i class="fa fa-shopping-basket" style="font-size: 36px; color: #cbd5e1; margin-bottom: 8px;"></i>
                                <div style="color: #64748b; font-weight: 600;">Belum ada catatan belanja.</div>
                                <p style="color: #94a3b8; font-size: 12px; margin-top: 4px;">Klik tombol "Catat Belanja" untuk menambahkan pengeluaran bahan baku.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>

{{-- MODAL TAMBAH BELANJA --}}
<div class="modal fade" id="modalAddExpense" tabindex="-1" role="dialog" aria-labelledby="modalAddExpenseLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
            <div class="modal-header" style="background-color: #5a351b; color: #ffffff;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff; opacity: 0.9;">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="modalAddExpenseLabel" style="font-weight: 700;">
                    <i class="fa fa-plus-circle"></i> Catat Pengeluaran Belanja Baru
                </h4>
            </div>
            <form action="{{ route('expense.store') }}" method="POST">
                {{ csrf_field() }}
                <div class="modal-body" style="padding: 20px;">
                    
                    <div class="form-group">
                        <label style="font-weight: 700;">Nama / Keterangan Belanja <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" placeholder="Contoh: Beras Rojo Lele 50kg & Telur 3 Peti" required>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label style="font-weight: 700;">Kategori Belanja <span class="text-danger">*</span></label>
                                <select name="category" class="form-control" required>
                                    <option value="Bahan Pokok">Bahan Pokok (Beras, Telur, Tepung)</option>
                                    <option value="Daging & Unggas">Daging & Unggas (Ayam, Sapi, Ikan)</option>
                                    <option value="Bumbu & Sayur">Bumbu, Sayur & Rempah</option>
                                    <option value="Kemasan / Packaging">Kemasan / Box Bento / Plastik</option>
                                    <option value="Operasional">Gas LPG, Minyak & Listrik</option>
                                    <option value="Lain-lain">Lain-lain</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label style="font-weight: 700;">Jumlah Pengeluaran (Rp) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-addon">Rp</span>
                                    <input type="number" name="amount" class="form-control" placeholder="Contoh: 750000" min="0" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label style="font-weight: 700;">Tanggal Belanja <span class="text-danger">*</span></label>
                        <input type="date" name="expense_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="form-group">
                        <label style="font-weight: 700;">Catatan / No. Nota (Opsional)</label>
                        <textarea name="notes" class="form-control" rows="2" placeholder="Contoh: Toko Beras Makmur - Nota #102"></textarea>
                    </div>

                </div>
                <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid #e2e8f0;">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" style="font-weight: 700; padding: 8px 18px;">
                        <i class="fa fa-save"></i> Simpan Catatan Belanja
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
{{-- Library Chart.js CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(document).ready(function() {
        // Data Finansial dari Backend
        var financeStats = {!! json_encode($financeStats) !!};

        // Data Grafik 3 Mode
        var chartDataModes = {
            daily: {
                subtitle: 'Tampilan Harian (7 Hari Terakhir)',
                labels: {!! json_encode($chartDailyLabels) !!},
                revenues: {!! json_encode($chartDailyRevenues) !!},
                expenses: {!! json_encode($chartDailyExpenses) !!}
            },
            weekly: {
                subtitle: 'Tampilan Mingguan (4 Minggu Terakhir)',
                labels: {!! json_encode($chartWeeklyLabels) !!},
                revenues: {!! json_encode($chartWeeklyRevenues) !!},
                expenses: {!! json_encode($chartWeeklyExpenses) !!}
            },
            monthly: {
                subtitle: 'Tampilan Bulanan (6 Bulan Terakhir)',
                labels: {!! json_encode($chartMonthlyLabels) !!},
                revenues: {!! json_encode($chartMonthlyRevenues) !!},
                expenses: {!! json_encode($chartMonthlyExpenses) !!}
            }
        };

        function formatRupiah(num) {
            return 'Rp ' + num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // Toggle Periode Pill (Hari Ini, Minggu Ini, Bulan Ini, Semua Waktu)
        $('.btn-period-pill').click(function() {
            var period = $(this).data('period');
            $('.btn-period-pill').removeClass('active');
            $(this).addClass('active');

            var stat = financeStats[period];
            if (stat) {
                $('#periodLabelBadge').html('<i class="fa fa-clock-o"></i> ' + stat.label);
                $('#cardRevenue').text(formatRupiah(stat.revenue));
                $('#cardExpense').text(formatRupiah(stat.expense));
                $('#cardProfit').text(formatRupiah(stat.profit));
                $('#cardOrders').html(stat.orders + ' <span style="font-size: 13px; font-weight: normal; color: #64748b;">Pesanan</span>');

                if (stat.profit >= 0) {
                    $('#cardProfit').removeClass('theme-rose').addClass('theme-blue');
                } else {
                    $('#cardProfit').removeClass('theme-blue').addClass('theme-rose');
                }

                $('#cardRevenueDesc').text('Pendapatan ' + stat.label);
                $('#cardExpenseDesc').text('Belanja ' + stat.label);
            }
        });

        // Inisialisasi Grafik Chart.js
        var ctx = document.getElementById('financeChart');
        var financeChartInstance = null;

        if (ctx) {
            var initial = chartDataModes.daily;

            financeChartInstance = new Chart(ctx.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: initial.labels,
                    datasets: [
                        {
                            label: 'Pendapatan (Revenue)',
                            data: initial.revenues,
                            backgroundColor: 'rgba(90, 53, 27, 0.85)',
                            borderColor: '#5a351b',
                            borderWidth: 1.5,
                            borderRadius: 4
                        },
                        {
                            label: 'Pengeluaran Belanja (Expense)',
                            data: initial.expenses,
                            backgroundColor: 'rgba(225, 29, 72, 0.75)',
                            borderColor: '#e11d48',
                            borderWidth: 1.5,
                            borderRadius: 4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                font: {
                                    family: "'Source Sans Pro', sans-serif",
                                    weight: 'bold'
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    var val = context.parsed.y || 0;
                                    return context.dataset.label + ': Rp ' + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    if (value >= 1000000) {
                                        return 'Rp ' + (value / 1000000).toFixed(1) + ' Jt';
                                    } else if (value >= 1000) {
                                        return 'Rp ' + (value / 1000).toFixed(0) + ' Rb';
                                    }
                                    return 'Rp ' + value;
                                }
                            },
                            grid: {
                                color: '#f1f5f9'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });

            // Toggle Grafik Mode (Harian, Mingguan, Bulanan)
            $('.btn-chart-mode').click(function() {
                var mode = $(this).data('mode');
                $('.btn-chart-mode').removeClass('active');
                $(this).addClass('active');

                var dataMode = chartDataModes[mode];
                if (dataMode && financeChartInstance) {
                    $('#chartSubtitle').text(dataMode.subtitle);
                    financeChartInstance.data.labels = dataMode.labels;
                    financeChartInstance.data.datasets[0].data = dataMode.revenues;
                    financeChartInstance.data.datasets[1].data = dataMode.expenses;
                    financeChartInstance.update();
                }
            });
        }
    });
</script>
@endsection
