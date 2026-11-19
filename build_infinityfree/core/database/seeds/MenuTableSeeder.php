<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Menu;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hasCategory = Schema::hasColumn('menu', 'category');

        $menus = [
            // Kategori: MAKANAN
            [
                'name' => 'Paket Nasi Kotak Ayam Bakar',
                'category' => 'makanan',
                'price' => 25000,
                'description' => 'Nasi putih pulen, ayam bakar bumbu kecap madu, tahu & tempe goreng, lalapan segar, sambal terasi khas katering.',
                'min_order' => 1,
                'pict' => 'sample.jpg'
            ],
            [
                'name' => 'Paket Nasi Kuning Komplit',
                'category' => 'makanan',
                'price' => 28000,
                'description' => 'Nasi kuning wangi gurih, ayam suwir pedas manis, orek tempe, perkedel kentang, telur dadar iris, sambal.',
                'min_order' => 1,
                'pict' => 'sample.jpg'
            ],
            [
                'name' => 'Paket Nasi Liwet Solo',
                'category' => 'makanan',
                'price' => 30000,
                'description' => 'Nasi liwet gurih beraroma daun salam, ayam opor suwir, sayur labu siam pedas, areh santan gurih.',
                'min_order' => 1,
                'pict' => 'sample.jpg'
            ],
            [
                'name' => 'Paket Bento Beef Teriyaki',
                'category' => 'makanan',
                'price' => 35000,
                'description' => 'Daging sapi iris saus teriyaki gurih manis, salad sayur mayonaise, chicken roll, nasi putih.',
                'min_order' => 1,
                'pict' => 'sample.jpg'
            ],
            [
                'name' => 'Snack Box Tradisional (3 Macam)',
                'category' => 'makanan',
                'price' => 15000,
                'description' => 'Lemper ayam spesial, risol mayo crispy, pastel isi sayur ayam telur, lengkap dengan air mineral.',
                'min_order' => 1,
                'pict' => 'sample.jpg'
            ],
            [
                'name' => 'Prasmanan Rendang Daging Sapi',
                'category' => 'makanan',
                'price' => 45000,
                'description' => 'Rendang daging sapi empuk kaya rempah, gulai ayam, tumis buncis bakso, kerupuk udang, buah semangka.',
                'min_order' => 1,
                'pict' => 'sample.jpg'
            ],

            // Kategori: MINUMAN
            [
                'name' => 'Es Lemon Tea Segar',
                'category' => 'minuman',
                'price' => 8000,
                'description' => 'Seduhan teh melati wangi dipadukan dengan perasan jeruk lemon asli dan es batu kristal yang menyegarkan dahaga.',
                'min_order' => 1,
                'pict' => 'sample.jpg'
            ],
            [
                'name' => 'Es Kopi Susu Gula Aren',
                'category' => 'minuman',
                'price' => 15000,
                'description' => 'Perpaduan double shot espresso pilihan dengan susu segar gurih creamy dan lelehan sirup gula aren murni.',
                'min_order' => 1,
                'pict' => 'sample.jpg'
            ],
            [
                'name' => 'Es Jeruk Murni Selasih',
                'category' => 'minuman',
                'price' => 10000,
                'description' => 'Jeruk peras manis segar pilihan dengan bulir jeruk berlimpah dan tambahan biji selasih kaya serat.',
                'min_order' => 1,
                'pict' => 'sample.jpg'
            ],
            [
                'name' => 'Jus Alpukat Kocok Kental',
                'category' => 'minuman',
                'price' => 16000,
                'description' => 'Alpukat mentega pilihan matang pohon, dikocok lembut dengan susu kental manis cokelat premium.',
                'min_order' => 1,
                'pict' => 'sample.jpg'
            ],
            [
                'name' => 'Wedang Jahe Rempah Hangat',
                'category' => 'minuman',
                'price' => 9000,
                'description' => 'Seduhan jahe merah bakar berkhasiat dengan serai, kayu manis, cengkeh, dan gula kelapa alami penambah stamina.',
                'min_order' => 1,
                'pict' => 'sample.jpg'
            ],
            [
                'name' => 'Air Mineral Botol Dingin (600ml)',
                'category' => 'minuman',
                'price' => 4000,
                'description' => 'Air mineral higienis pegunungan kemasan botol 600ml dingin segar.',
                'min_order' => 1,
                'pict' => 'sample.jpg'
            ],
        ];

        foreach ($menus as $item) {
            $data = $item;
            if (!$hasCategory) {
                unset($data['category']);
            }
            // Update jika sudah ada atau buat baru
            $existing = Menu::where('name', $item['name'])->first();
            if ($existing) {
                if ($hasCategory) {
                    $existing->category = $item['category'];
                    $existing->save();
                }
            } else {
                Menu::create($data);
            }
        }
    }
}
