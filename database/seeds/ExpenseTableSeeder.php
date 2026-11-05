<?php

use Illuminate\Database\Seeder;
use App\Expense;
use Carbon\Carbon;

class ExpenseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $expenses = [
            [
                'title' => 'Beras Rojo Lele 50kg & Telur 3 Peti',
                'category' => 'Bahan Pokok',
                'amount' => 1150000,
                'expense_date' => $now->copy()->subDays(1)->format('Y-m-d'),
                'notes' => 'Pasar Induk - Nota #B01',
            ],
            [
                'title' => 'Daging Ayam 30kg & Sapi Fillet 10kg',
                'category' => 'Daging & Unggas',
                'amount' => 2450000,
                'expense_date' => $now->copy()->subDays(2)->format('Y-m-d'),
                'notes' => 'Supplier Daging Segar',
            ],
            [
                'title' => 'Bumbu Dapur, Cabai & Bawang Merah',
                'category' => 'Bumbu & Rempah',
                'amount' => 680000,
                'expense_date' => $now->copy()->subDays(3)->format('Y-m-d'),
                'notes' => 'Toko Bumbu Barokah',
            ],
            [
                'title' => 'Kotak Bento Sekat, Sendok & Plastik',
                'category' => 'Kemasan / Packaging',
                'amount' => 450000,
                'expense_date' => $now->copy()->subDays(5)->format('Y-m-d'),
                'notes' => 'Toko Plastik Makmur (1000 pcs)',
            ],
            [
                'title' => 'Minyak Goreng SunCo 12L & Gas LPG',
                'category' => 'Operasional',
                'amount' => 320000,
                'expense_date' => $now->copy()->subDays(7)->format('Y-m-d'),
                'notes' => 'Pangkalan Gas & Agen Minyak',
            ],
            [
                'title' => 'Sayuran Segar & Buah Semangka Melon',
                'category' => 'Sayur & Buah',
                'amount' => 510000,
                'expense_date' => $now->copy()->subDays(8)->format('Y-m-d'),
                'notes' => 'Pasar Pagi Buah',
            ],
        ];

        foreach ($expenses as $item) {
            Expense::create($item);
        }
    }
}

