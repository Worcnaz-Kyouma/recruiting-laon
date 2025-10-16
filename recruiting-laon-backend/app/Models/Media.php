<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model {
    protected $fillable = ['tmdb_id', 'media_type'];
    protected $hidden = ['pivot'];

    public function mediaLists() {
        return $this->belongsToMany(MediaList::class, "media_list_media");
    }
}
