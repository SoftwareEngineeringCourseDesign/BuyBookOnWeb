<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchiveBook extends Model
{
    protected $table = 'archive_book';

    public function book() {
        return $this->belongsTo('App\Models\Book', 'book_id', 'id');
    }
}
