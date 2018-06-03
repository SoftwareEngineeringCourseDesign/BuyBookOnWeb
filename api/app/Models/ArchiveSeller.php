<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchiveSeller extends Model
{
    protected $table = 'archive_seller';

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
