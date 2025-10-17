<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaList extends Model {
    protected $fillable = ['name', 'user_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function medias() {
        return $this->belongsToMany(Media::class, "media_list_media");
    }
}
