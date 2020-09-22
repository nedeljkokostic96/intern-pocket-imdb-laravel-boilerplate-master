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
        if ($this->checkIfWatchExists($user->id, $request->movieId)) {
            $watch->movie_id = $request->movieId;
            $watch->user_id = $user->id;
            $watch->watched = false;
            $watch->save();
        }
        return $this->index();

    }

    private function checkIfWatchExists($user_id, $movie_id){
        $watches = WatchList::where('user_id', '=', $user_id)
                            ->where('movie_id', '=', $movie_id)
                            ->get();
        return count($watches) === 0;
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
        $watch->save();
        return $this->index();
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
        if ($watch){
            $watch->delete();
        }
        return $this->index();
    }
}
