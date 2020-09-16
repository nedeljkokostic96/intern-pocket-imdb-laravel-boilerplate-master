<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Like;

class LikeController extends Controller
{

    private function checkIfLiked($movieId, $userId)
    {
        $match = ['movie_id' => $movieId, 'user_id' => $userId];
        return count(Like::where($match)->get());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //return Auth::user();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if ($this->checkIfLiked($request->movieId, $user->id)) {
            return json_encode([
                'status' => false,
                'message' => 'Cannot add like!'
            ]);
        }
        $like = new Like();
        $like->liked = $request->liked;
        $like->movie_id = $request->movieId;
        $like->user_id = $user->id;
        if (!$like->save()) {
            return json_encode([
                'status' => false,
                'message' => 'Cannot add like!'
            ]);
        }
        return json_encode([
            'status' => true,
            'message' => 'Movie liked!'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
