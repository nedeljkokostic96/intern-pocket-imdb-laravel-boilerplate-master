<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    
    public $table = 'images';

    public function movie()
    {
        return $this->belongsTo('App\Movie');
    }
}
