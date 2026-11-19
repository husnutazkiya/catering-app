<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menu';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Accessor untuk kategori.
     * Mengembalikan nilai 'minuman' atau 'makanan'.
     * Jika field di DB belum ada atau masih kosong, otomatis mendeteksi dari nama & deskripsi.
     */
    public function getCategoryAttribute($value)
    {
        if (!empty($value)) {
            return strtolower($value);
        }

        $text = strtolower(($this->name ?? '') . ' ' . ($this->description ?? ''));
        $drinkKeywords = [
            'es ', 'jus', 'teh', 'tea', 'kopi', 'coffee', 'air mineral', 'minuman', 
            'lemon', 'shake', 'smoothie', 'wedang', 'sirup', 'drink', 'soda', 'boba', 'latte', 'jeruk'
        ];

        foreach ($drinkKeywords as $keyword) {
            if (str_contains($text, $keyword)) {
                return 'minuman';
            }
        }

        return 'makanan';
    }

    /**
     * Label Kategori yang Rapi untuk Tampilan
     */
    public function getCategoryLabelAttribute()
    {
        return $this->category === 'minuman' ? 'Minuman' : 'Makanan';
    }
}
