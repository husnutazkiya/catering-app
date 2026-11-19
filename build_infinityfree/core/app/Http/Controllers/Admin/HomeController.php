<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\Controller;
use App\Menu;
use App\User;
use App\Order;
use App\Expense;
use Carbon\Carbon;
use Auth;

class HomeController extends Controller
{
    public function index()
    {
        $menuCount = Menu::count();
        $userCount = User::count();
        $pendingOrder = Order::where('status', '!=', 2)->count();
        $completeOrder = Order::where('status', 2)->count();

        $hasExpenses = Schema::hasTable('expenses');

        $today = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // 1. DATA HARI INI (DAILY)
        $revToday = (int) Order::where(function ($q) use ($today) {
            $q->whereDate('order_for', $today)->orWhereDate('created_at', $today);
        })->sum('total');
        $expToday = $hasExpenses ? (int) Expense::whereDate('expense_date', $today)->sum('amount') : 0;
        $profitToday = $revToday - $expToday;
        $ordersToday = Order::where(function ($q) use ($today) {
            $q->whereDate('order_for', $today)->orWhereDate('created_at', $today);
        })->count();

        // 2. DATA MINGGU INI (WEEKLY)
        $revWeek = (int) Order::where(function ($q) use ($startOfWeek, $endOfWeek) {
            $q->whereBetween('order_for', [$startOfWeek, $endOfWeek])
              ->orWhereBetween('created_at', [$startOfWeek, $endOfWeek]);
        })->sum('total');
        $expWeek = $hasExpenses ? (int) Expense::whereBetween('expense_date', [$startOfWeek, $endOfWeek])->sum('amount') : 0;
        $profitWeek = $revWeek - $expWeek;
        $ordersWeek = Order::where(function ($q) use ($startOfWeek, $endOfWeek) {
            $q->whereBetween('order_for', [$startOfWeek, $endOfWeek])
              ->orWhereBetween('created_at', [$startOfWeek, $endOfWeek]);
        })->count();

        // 3. DATA BULAN INI (MONTHLY)
        $revMonth = (int) Order::where(function ($q) use ($startOfMonth, $endOfMonth) {
            $q->whereBetween('order_for', [$startOfMonth, $endOfMonth])
              ->orWhereBetween('created_at', [$startOfMonth, $endOfMonth]);
        })->sum('total');
        $expMonth = $hasExpenses ? (int) Expense::whereBetween('expense_date', [$startOfMonth, $endOfMonth])->sum('amount') : 0;
        $profitMonth = $revMonth - $expMonth;
        $ordersMonth = Order::where(function ($q) use ($startOfMonth, $endOfMonth) {
            $q->whereBetween('order_for', [$startOfMonth, $endOfMonth])
              ->orWhereBetween('created_at', [$startOfMonth, $endOfMonth]);
        })->count();

        // 4. DATA SEMUA WAKTU (ALL TIME)
        $revAll = (int) Order::sum('total');
        $expAll = $hasExpenses ? (int) Expense::sum('amount') : 0;
        $profitAll = $revAll - $expAll;
        $ordersAll = Order::count();

        // Package stats for each period to make switching effortless in JavaScript
        $financeStats = [
            'today' => [
                'label' => 'Hari Ini (' . $today->format('d M Y') . ')',
                'revenue' => $revToday,
                'expense' => $expToday,
                'profit' => $profitToday,
                'orders' => $ordersToday,
                'desc' => 'Perhitungan transaksi khusus hari ini'
            ],
            'week' => [
                'label' => 'Minggu Ini (' . $startOfWeek->format('d M') . ' - ' . $endOfWeek->format('d M Y') . ')',
                'revenue' => $revWeek,
                'expense' => $expWeek,
                'profit' => $profitWeek,
                'orders' => $ordersWeek,
                'desc' => 'Akumulasi transaksi minggu berjalan'
            ],
            'month' => [
                'label' => 'Bulan Ini (' . Carbon::now()->format('F Y') . ')',
                'revenue' => $revMonth,
                'expense' => $expMonth,
                'profit' => $profitMonth,
                'orders' => $ordersMonth,
                'desc' => 'Akumulasi transaksi bulan berjalan'
            ],
            'all' => [
                'label' => 'Semua Waktu (Akumulasi)',
                'revenue' => $revAll,
                'expense' => $expAll,
                'profit' => $profitAll,
                'orders' => $ordersAll,
                'desc' => 'Seluruh riwayat transaksi katering'
            ],
        ];

        // 5. DATA GRAFIK HARIAN (7 Hari Terakhir)
        $chartDailyLabels = [];
        $chartDailyRevenues = [];
        $chartDailyExpenses = [];
        for ($i = 6; $i >= 0; $i--) {
            $d = Carbon::now()->subDays($i);
            $chartDailyLabels[] = $d->format('D, d M');
            $r = (int) Order::where(function ($q) use ($d) {
                $q->whereDate('order_for', $d)->orWhereDate('created_at', $d);
            })->sum('total');
            $e = $hasExpenses ? (int) Expense::whereDate('expense_date', $d)->sum('amount') : 0;
            $chartDailyRevenues[] = $r;
            $chartDailyExpenses[] = $e;
        }

        // 6. DATA GRAFIK MINGGUAN (4 Minggu Terakhir)
        $chartWeeklyLabels = [];
        $chartWeeklyRevenues = [];
        $chartWeeklyExpenses = [];
        for ($i = 3; $i >= 0; $i--) {
            $wStart = Carbon::now()->subWeeks($i)->startOfWeek();
            $wEnd = Carbon::now()->subWeeks($i)->endOfWeek();
            $chartWeeklyLabels[] = $i == 0 ? 'Mg Ini (' . $wStart->format('d/m') . ')' : 'Mg -' . $i . ' (' . $wStart->format('d/m') . ')';
            $r = (int) Order::where(function ($q) use ($wStart, $wEnd) {
                $q->whereBetween('order_for', [$wStart, $wEnd])->orWhereBetween('created_at', [$wStart, $wEnd]);
            })->sum('total');
            $e = $hasExpenses ? (int) Expense::whereBetween('expense_date', [$wStart, $wEnd])->sum('amount') : 0;
            $chartWeeklyRevenues[] = $r;
            $chartWeeklyExpenses[] = $e;
        }

        // 7. DATA GRAFIK BULANAN (6 Bulan Terakhir)
        $chartMonthlyLabels = [];
        $chartMonthlyRevenues = [];
        $chartMonthlyExpenses = [];
        for ($i = 5; $i >= 0; $i--) {
            $m = Carbon::now()->subMonths($i);
            $chartMonthlyLabels[] = $m->format('M Y');
            $year = $m->year;
            $month = $m->month;
            $r = (int) Order::where(function ($q) use ($year, $month) {
                $q->whereYear('order_for', $year)->whereMonth('order_for', $month)
                  ->orWhere(function ($sq) use ($year, $month) {
                      $sq->whereYear('created_at', $year)->whereMonth('created_at', $month);
                  });
            })->sum('total');
            $e = $hasExpenses ? (int) Expense::whereYear('expense_date', $year)->whereMonth('expense_date', $month)->sum('amount') : 0;
            $chartMonthlyRevenues[] = $r;
            $chartMonthlyExpenses[] = $e;
        }

        // Daftar Belanja Terbaru
        $recentExpenses = $hasExpenses
            ? Expense::orderBy('expense_date', 'DESC')->limit(7)->get()
            : collect([]);

        return view('dashboard.home', compact(
            'menuCount', 'userCount', 'pendingOrder', 'completeOrder',
            'financeStats', 'recentExpenses',
            'chartDailyLabels', 'chartDailyRevenues', 'chartDailyExpenses',
            'chartWeeklyLabels', 'chartWeeklyRevenues', 'chartWeeklyExpenses',
            'chartMonthlyLabels', 'chartMonthlyRevenues', 'chartMonthlyExpenses'
        ));
    }

    public function tablesQr(Request $request)
    {
        $totalTables = (int) $request->get('count', 12);
        $tables = [];

        for ($i = 1; $i <= $totalTables; $i++) {
            $tableNumber = str_pad($i, 2, '0', STR_PAD_LEFT);
            $tableName = 'Meja ' . $tableNumber;
            $scanUrl = url('/scan?table=' . urlencode($tableName));
            $qrApiUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=' . urlencode($scanUrl);

            $tables[] = [
                'id' => $i,
                'name' => $tableName,
                'url' => $scanUrl,
                'qr_image' => $qrApiUrl,
            ];
        }

        return view('dashboard.tables-qr', compact('tables', 'totalTables'));
    }

    public function blank()
    {
        return view('dashboard.blank');
    }
}
