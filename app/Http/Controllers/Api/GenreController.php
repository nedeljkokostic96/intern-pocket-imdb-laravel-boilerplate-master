<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Genre;

class GenreController extends Controller
{
    public function index() 
    {
        return Genre::all();
    }
}
