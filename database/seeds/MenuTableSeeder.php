<?php

use Illuminate\Database\Seeder;
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
        $menus = [
            [
                'name' => 'Paket Nasi Kotak Ayam Bakar',
                'price' => 25000,
                'description' => 'Nasi putih pulen, ayam bakar bumbu kecap madu, tahu & tempe goreng, lalapan segar, sambal terasi khas katering.',
                'min_order' => 5,
                'pict' => 'sample.jpg'
            ],
            [
                'name' => 'Paket Nasi Kuning Komplit',
                'price' => 28000,
                'description' => 'Nasi kuning wangi gurih, ayam suwir pedas manis, orek tempe, perkedel kentang, telur dadar iris, sambal.',
                'min_order' => 5,
                'pict' => 'sample.jpg'
            ],
            [
                'name' => 'Paket Nasi Liwet Solo',
                'price' => 30000,
                'description' => 'Nasi liwet gurih beraroma daun salam, ayam opor suwir, sayur labu siam pedas, areh santan gurih.',
                'min_order' => 10,
                'pict' => 'sample.jpg'
            ],
            [
                'name' => 'Paket Bento Beef Teriyaki',
                'price' => 35000,
                'description' => 'Daging sapi iris saus teriyaki gurih manis, salad sayur mayonaise, chicken roll, nasi putih.',
                'min_order' => 5,
                'pict' => 'sample.jpg'
            ],
            [
                'name' => 'Snack Box Tradisional (3 Macam)',
                'price' => 15000,
                'description' => 'Lemper ayam spesial, risol mayo crispy, pastel isi sayur ayam telur, lengkap dengan air mineral.',
                'min_order' => 15,
                'pict' => 'sample.jpg'
            ],
            [
                'name' => 'Prasmanan Rendang Daging Sapi',
                'price' => 45000,
                'description' => 'Rendang daging sapi empuk kaya rempah, gulai ayam, tumis buncis bakso, kerupuk udang, buah semangka.',
                'min_order' => 20,
                'pict' => 'sample.jpg'
            ],
        ];

        foreach ($menus as $item) {
            Menu::create($item);
        }
    }
}

