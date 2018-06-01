<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchiveSeller extends Model
{
    protected $table = 'archive_seller';

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
