<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function user() {
        return $this->belongsTo('App\User')->withDefault(function ($user, $order) {
            $user->name = $order->customer_name ?: ($order->table_no ? 'Tamu (' . $order->table_no . ')' : 'Pelanggan Tamu (QR)');
            $user->email = '-';
        });
    }

    public function menu() {
        return $this->belongsTo('App\Menu');
    }
}
