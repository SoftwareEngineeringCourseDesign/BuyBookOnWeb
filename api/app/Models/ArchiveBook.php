<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchiveBook extends Model
{
    protected $table = 'archive_book';

    public function book() {
        return $this->belongsTo('App\Models\Book', 'book_id', 'id');
    }

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function getAttachmentsAttribute () {
        try {
            $attachments = json_decode($this->attributes['attachments']);
        } catch (\Exception $e) {
            $attachments = [];
        }
        if ($attachments === null) $attachments = [];
        return $attachments;
    }

    public function setAttachmentsAttribute ($value) {
        try {
            $attachments = json_encode($value);
        } catch (\Exception $e) {
            $attachments = '[]';
        }
        if ($attachments === null) $attachments = '[]';
        $this->attributes['attachments'] = $attachments;
    }
}
