<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    public $timestamps = false;

    public function movies()
    {
        return $this->hasMany('App\Movie', 'genre_id', 'id')->withDefault();
    }
}
