<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Menu;

class HomeController extends Controller
{
    /**
     * Tampilkan halaman utama (Daftar Menu).
     * Dapat diakses oleh tamu (guest/scan QR meja) maupun member yang login.
     * Mendukung tab pilihan kategori: Semua, Makanan, dan Minuman.
     */
    public function index(Request $request)
    {
        // Hapus nomor meja jika diminta (?clear_table=1) atau simpan jika diakses dari scan QR meja (?table=Meja%2001)
        if ($request->has('clear_table')) {
            session()->forget('table_no');
        } elseif ($request->has('table')) {
            session(['table_no' => $request->table]);
        }

        $currentTable = session('table_no');
        $activeCategory = strtolower($request->get('category', 'all'));
        if (!in_array($activeCategory, ['all', 'makanan', 'minuman'])) {
            $activeCategory = 'all';
        }

        $hasCategoryCol = Schema::hasColumn('menu', 'category');

        // Kata kunci penentu minuman (jika kolom category belum dimigrasikan)
        $drinkKeywords = [
            'es ', 'jus', 'teh', 'tea', 'kopi', 'coffee', 'air mineral', 'minuman', 
            'lemon', 'shake', 'smoothie', 'wedang', 'sirup', 'drink', 'soda', 'boba', 'latte', 'jeruk'
        ];

        // Hitung jumlah masing-masing kategori
        $allMenus = Menu::all();
        $countAll = $allMenus->count();
        $countMinuman = $allMenus->filter(function ($item) {
            return $item->category === 'minuman';
        })->count();
        $countMakanan = $countAll - $countMinuman;

        // Query daftar menu sesuai tab aktif
        $query = Menu::orderBy('updated_at', 'DESC');

        if ($activeCategory === 'minuman') {
            if ($hasCategoryCol) {
                $query->where('category', 'minuman');
            } else {
                $query->where(function ($q) use ($drinkKeywords) {
                    foreach ($drinkKeywords as $idx => $kw) {
                        if ($idx === 0) {
                            $q->where('name', 'LIKE', '%' . $kw . '%')
                              ->orWhere('description', 'LIKE', '%' . $kw . '%');
                        } else {
                            $q->orWhere('name', 'LIKE', '%' . $kw . '%')
                              ->orWhere('description', 'LIKE', '%' . $kw . '%');
                        }
                    }
                });
            }
        } elseif ($activeCategory === 'makanan') {
            if ($hasCategoryCol) {
                $query->where(function ($q) {
                    $q->where('category', 'makanan')
                      ->orWhereNull('category')
                      ->orWhere('category', '!=', 'minuman');
                });
            } else {
                $query->where(function ($q) use ($drinkKeywords) {
                    foreach ($drinkKeywords as $kw) {
                        $q->where('name', 'NOT LIKE', '%' . $kw . '%');
                    }
                });
            }
        }

        // Tampilkan 12 menu per halaman dan pertahankan parameter URL (meja & category)
        $menus = $query->paginate(12)->appends($request->all());

        return view('home', compact(
            'menus', 
            'currentTable', 
            'activeCategory', 
            'countAll', 
            'countMakanan', 
            'countMinuman'
        ));
    }

    /**
     * Endpoint langsung saat scan QR meja (/scan?table=Meja 01)
     */
    public function scanTable(Request $request)
    {
        $table = $request->get('table', 'Meja 01');
        session(['table_no' => $table]);
        
        return redirect()->route('home');
    }
}
