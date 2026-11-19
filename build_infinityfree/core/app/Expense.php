<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $table = 'expenses';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function user() {
        return $this->belongsTo('App\User', 'created_by');
    }
}

