<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function genre()
    {
        return $this->belongsTo('App\Genre', 'genre_id', 'id')->withDefault();
    }

    public function watchLists()
    {
        return $this->hasMany(WatchList::class);
    }

    public function image()
    {
        return $this->hasOne(Image::class);
    }
}
