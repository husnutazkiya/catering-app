<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Menu;
use App\Order;
use Carbon\Carbon;
use Auth;

class OrderController extends Controller
{
    public static $availableAddons = [
        'sambal' => [
            'id' => 'sambal',
            'name' => 'Sambal Ekstra Spesial (Cup)',
            'price' => 3000,
            'desc' => 'Sambal terasi / bawang ekstra pedas gurih',
            'icon' => 'fa-fire'
        ],
        'kerupuk' => [
            'id' => 'kerupuk',
            'name' => 'Kerupuk Udang Renyah',
            'price' => 4000,
            'desc' => 'Kerupuk udang renyah kemasan higienis',
            'icon' => 'fa-certificate'
        ],
        'es_teh' => [
            'id' => 'es_teh',
            'name' => 'Es Teh Manis Segar',
            'price' => 4000,
            'desc' => 'Teh melati manis dingin dalam cup',
            'icon' => 'fa-glass'
        ],
        'air_mineral' => [
            'id' => 'air_mineral',
            'name' => 'Air Mineral Botol 600ml',
            'price' => 4000,
            'desc' => 'Air mineral kemasan botol dingin / netral',
            'icon' => 'fa-tint'
        ],
        'telur_balado' => [
            'id' => 'telur_balado',
            'name' => 'Tambahan Telur Balado',
            'price' => 5000,
            'desc' => '1 butir telur ayam balado bumbu merah meresap',
            'icon' => 'fa-circle'
        ],
        'bento_box' => [
            'id' => 'bento_box',
            'name' => 'Kemasan Kotak Bento & Cutlery',
            'price' => 3000,
            'desc' => 'Kotak bento sekat eksklusif + sendok garpu tisu',
            'icon' => 'fa-cutlery'
        ],
        'buah' => [
            'id' => 'buah',
            'name' => 'Buah Potong Segar (Semangka/Melon)',
            'price' => 3000,
            'desc' => 'Buah potong segar kemasan tertutup',
            'icon' => 'fa-leaf'
        ],
    ];

    /**
     * Detail menu dan pemilihan add-ons
     */
    public function getOrder($id) {
        $menu = Menu::findOrFail($id);
        $date = Carbon::now();
        $addons = self::$availableAddons;
        $currentTable = session('table_no');
        return view('order', compact('menu', 'date', 'addons', 'currentTable'));
    }

    /**
     * Memasukkan menu + add-ons ke keranjang
     */
    public function addToCart(Request $request) {
        $menu = Menu::findOrFail($request->menu_id);
        $qty = max((int)$request->qty, (int)$menu->min_order);
        
        $selectedAddons = [];
        $addonsTotal = 0;
        if ($request->has('addons') && is_array($request->addons)) {
            foreach ($request->addons as $addonId) {
                if (isset(self::$availableAddons[$addonId])) {
                    $item = self::$availableAddons[$addonId];
                    $selectedAddons[] = [
                        'id' => $addonId,
                        'name' => $item['name'],
                        'price' => $item['price']
                    ];
                    $addonsTotal += $item['price'];
                }
            }
        }

        $unitPrice = $menu->price + $addonsTotal;
        $subtotal = $unitPrice * $qty;
        
        $addonKeys = array_column($selectedAddons, 'id');
        sort($addonKeys);
        $cartKey = $menu->id . '_' . implode('-', $addonKeys);

        $cart = session()->get('cart', []);

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['qty'] += $qty;
            $cart[$cartKey]['subtotal'] = $cart[$cartKey]['price_per_unit'] * $cart[$cartKey]['qty'];
        } else {
            $cart[$cartKey] = [
                'key' => $cartKey,
                'menu_id' => $menu->id,
                'name' => $menu->name,
                'pict' => $menu->pict,
                'menu_price' => $menu->price,
                'min_order' => $menu->min_order,
                'addons' => $selectedAddons,
                'addons_total' => $addonsTotal,
                'price_per_unit' => $unitPrice,
                'qty' => $qty,
                'subtotal' => $subtotal,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('viewCart')->with('success', 'Menu "' . $menu->name . '" berhasil ditambahkan ke keranjang!');
    }

    /**
     * Halaman Keranjang Belanja & Kalkulasi Total Harga
     */
    public function viewCart() {
        $cart = session()->get('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['subtotal'];
        }
        $date = Carbon::now();
        $currentTable = session('table_no');
        return view('cart', compact('cart', 'total', 'date', 'currentTable'));
    }

    /**
     * Update jumlah qty item di keranjang
     */
    public function updateCart(Request $request) {
        $cart = session()->get('cart', []);
        $key = $request->key;
        if (isset($cart[$key])) {
            $min = (int)$cart[$key]['min_order'];
            $newQty = max((int)$request->qty, $min);
            $cart[$key]['qty'] = $newQty;
            $cart[$key]['subtotal'] = $cart[$key]['price_per_unit'] * $newQty;
            session()->put('cart', $cart);
        }
        return redirect()->route('viewCart')->with('success', 'Jumlah pesanan berhasil diperbarui!');
    }

    /**
     * Hapus item dari keranjang
     */
    public function removeFromCart(Request $request) {
        $cart = session()->get('cart', []);
        $key = $request->key;
        if (isset($cart[$key])) {
            unset($cart[$key]);
            session()->put('cart', $cart);
        }
        return redirect()->route('viewCart')->with('info', 'Item berhasil dihapus dari keranjang.');
    }

    /**
     * Checkout seluruh isi keranjang menjadi pesanan
     * Mendukung Member yang login maupun Tamu Scan QR Meja (Tanpa Login)
     */
    public function checkoutCart(Request $request) {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Keranjang pesanan Anda masih kosong!');
        }

        $tableNo = $request->table_no ?: session('table_no');
        $isTableOrder = !empty($tableNo);

        $forDate = $request->for_date ?: date('Y-m-d');
        $forTime = $request->for_time ?: date('H:i');
        $dateTime = date('Y-m-d H:i:s', strtotime($forDate . ' ' . $forTime));

        $typeOption = $request->get('order_type_option');
        if ($typeOption === 'takeaway') {
            $orderType = 'takeaway';
            $delivery = 0;
            $address = 'Bungkus / Bawa Pulang (Takeaway)';
        } elseif ($typeOption === 'dine_in' || $isTableOrder) {
            $orderType = 'dine_in';
            $delivery = 0;
            $address = 'Makan di Tempat - ' . ($tableNo ?: 'Meja Tamu');
        } else {
            $delivery = $request->deliver == '1' ? 1 : 0;
            $orderType = $delivery ? 'delivery' : 'takeaway';
            $address = $delivery ? ($request->to_addr ?: 'Alamat Pengantaran') : 'Ambil Sendiri di Toko Katering';
        }

        // Tentukan identitas pemesan (Member Login vs Tamu Scan QR Meja)
        if (Auth::check()) {
            $userId = Auth::id();
            $customerName = $request->customer_name ?: Auth::user()->name;
            $customerPhone = $request->customer_phone ?: (isset(Auth::user()->profile) ? Auth::user()->profile->phone : '-');
        } else {
            $userId = null;
            $customerName = $request->customer_name ?: ($tableNo ? 'Tamu (' . $tableNo . ')' : 'Pelanggan Tamu (QR)');
            $customerPhone = $request->customer_phone ?: '-';
        }

        $hasAddonsCol = Schema::hasColumn('order', 'addons');
        $hasTableCol = Schema::hasColumn('order', 'table_no');

        foreach ($cart as $item) {
            $order = new Order;
            $order->user_id = $userId;
            $order->menu_id = $item['menu_id'];
            
            $addonsNames = [];
            if (!empty($item['addons'])) {
                foreach ($item['addons'] as $addon) {
                    $addonsNames[] = $addon['name'] . ' (+Rp ' . number_format($addon['price'], 0, ',', '.') . ')';
                }
            }
            if ($hasAddonsCol && !empty($addonsNames)) {
                $order->addons = implode(', ', $addonsNames);
            }

            if ($hasTableCol) {
                $order->table_no = $tableNo;
                $order->customer_name = $customerName;
                $order->customer_phone = $customerPhone;
                $order->order_type = $orderType;
            }
            
            $order->qty = $item['qty'];
            $order->total = $item['subtotal'];
            $order->order_for = $dateTime;
            $order->delivery = $delivery;
            $order->to_addr = $address;
            $order->status = 0; // Menunggu konfirmasi katering
            $order->save();
        }

        // Simpan info pesanan terakhir ke session untuk nota tamu/QR
        session([
            'last_order_info' => [
                'table_no' => $tableNo,
                'customer_name' => $customerName,
                'customer_phone' => $customerPhone,
                'order_type' => $orderType,
                'address' => $address,
                'time' => $dateTime,
                'items' => array_values($cart),
                'total_items' => count($cart),
                'grand_total' => array_sum(array_column($cart, 'subtotal')),
            ]
        ]);

        session()->forget('cart');

        return redirect()->route('successOrder');
    }

    public function postOrder(Request $request) {
        return $this->addToCart($request);
    }

    public function listOrder() {
        $orders = Order::where('status', '!=', 2)->where('user_id', Auth::id())->orderBy('updated_at', 'DESC')->get();
        return view('order-list', compact('orders'));
    }

    public function detailOrder($id) {
        $order = Order::findOrFail($id);
        return view('order-detail', compact('order'));
    }

    public function cancelOrder(Request $request, $id) {
        $order = Order::destroy($request->id);
        return redirect()->route('listOrder')->with('message', 'Sesuai permintaan kamu, Pesanan kami batalkan. Terimakasih, Silahkan lakukan pemesanan kembali.');
    }

    public function successOrder() {
        $lastOrder = session('last_order_info');
        return view('order-success', compact('lastOrder'));
    }
}
