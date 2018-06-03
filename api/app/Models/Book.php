<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'book';

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function category() {
        return $this->belongsTo('App\Models\Category', 'category_id', 'id');
    }

    public static function create() {
        $book = new Book();
        $book->sum_score = 0;
        $book->score = 0;
        $book->sell_number = 0;
        $book->people_number = 0;
        $book->passed = 0;
        $book->save();
        return $book;
    }
}
