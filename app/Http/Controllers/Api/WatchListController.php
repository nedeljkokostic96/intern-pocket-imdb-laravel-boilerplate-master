<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\WatchList;

class WatchListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        return WatchList::with('user', 'movie')->where('user_id', '=', $user->id)->get();
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
        $watch = new WatchList();
        $watch->movie_id = $request->movieId;
        $watch->user_id = $user->id;
        $watch->watched = false;
        if ($watch->save()){
            return json_encode([
                'status' => true,
                'message' => 'Watch added!'
            ]);
        }
        return json_encode([
            'status' => false,
            'message' => 'Not added!'
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
        $watch = WatchList::find($id);
        $watch->watched = true;
        if ($watch->save()){
            return json_encode([
                'status' => true,
                'message' => 'Marked as watched!'
            ]);
        }
        return json_encode([
            'status' => false,
            'message' => 'Not marked as watched!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $watch = WatchList::find($id);
        if ($watch->delete()){
            return json_encode([
                'status' => true,
                'message' => 'Deleted!'
            ]);
        }
        return json_encode([
            'status' => false,
            'message' => 'Not deleted!'
        ]);
    }
}
