<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;

class UserController extends Controller
{
    public function getCurrentUser()
    {
        $user = Auth::user();
        return User::with('watchLists')->where('id', '=', $user->id)->get();
    }
}
