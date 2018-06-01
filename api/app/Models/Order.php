<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
    public function book() {
        return $this->belongsTo('App\Models\Book', 'book_id', 'id');
    }
}
