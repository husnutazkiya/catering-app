<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Menu;

class HomeController extends Controller
{
    /**
     * Tampilkan halaman utama (Daftar Menu).
     * Dapat diakses oleh tamu (guest/scan QR meja) maupun member yang login.
     */
    public function index(Request $request)
    {
        // Hapus nomor meja jika diminta (?clear_table=1) atau simpan jika diakses dari scan QR meja (?table=Meja%2001)
        if ($request->has('clear_table')) {
            session()->forget('table_no');
        } elseif ($request->has('table')) {
            session(['table_no' => $request->table]);
        }

        $menus = Menu::orderBy('updated_at', 'DESC')->paginate(8);
        $currentTable = session('table_no');

        return view('home', compact('menus', 'currentTable'));
    }

    /**
     * Endpoint langsung saat scan QR meja (/scan?table=Meja 01)
     */
    public function scanTable(Request $request)
    {
        $table = $request->get('table', 'Meja 01');
        session(['table_no' => $table]);
        
        return redirect()->route('home')->with('info', '🍽️ Selamat datang! Anda terhubung ke ' . $table . '. Silakan pilih menu dan pesan langsung tanpa perlu login.');
    }
}
