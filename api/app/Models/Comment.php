<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comment';

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function book() {
        return $this->belongsTo('App\Models\Book', 'book_id', 'id');
    }
}
