<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WatchList extends Model
{
    protected $table = 'watch_lists';

    public function movie()
    {
        return $this->belongsTo('App\Movie', 'movie_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
