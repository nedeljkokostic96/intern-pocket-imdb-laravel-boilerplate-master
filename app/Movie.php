<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Genre;

class Movie extends Model
{
    //
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function genre()
    {
        return $this->belongsTo('App\Genre', 'genre_id', 'id')->withDefault();
    }
}
