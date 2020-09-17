<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

use App\Movie;
use DB;

class MovieController extends Controller
{
    public function getRelatedMovies($movieId)
    {
        $movie = Movie::find($movieId);
        return Movie::where('genre_id', '=', $movie->genre_id)
                    ->where('id', '<>', $movie->id)
                    ->limit(10)
                    ->get();
    }

    public function getHotestMovies($numOfHotest)
    {
        $movies = Movie::with('genre', 'likes')->get();
        $moviesMapped = [];
        foreach ($movies as $movie) {
            $likesCounter = 0;
            foreach ($movie->likes as $like){
                $like->liked ? $likesCounter++ : $likesCounter;
            }
            $mapped = [
                'likes' => $likesCounter,
                'movie' => $movie
            ];
            $moviesMapped[] = $mapped;
        }
        usort($moviesMapped, function($a, $b) {
            return $b["likes"] - $a["likes"];
        });
        return array_slice($moviesMapped, 0, $numOfHotest);
    }


    public function getMoviesByGenre($genreId)
    {
        return Movie::where('genre_id', '=', $genreId)->with('genre', 'likes')->get();
        
    }

    public function incrementMovieViews($id) 
    {
        $movie = Movie::find($id);
        $movie->views = $movie->views + 1;
        if ($movie->save()) {
            return json_encode([
                'status' => true,
                'message' => 'View added successfully!'
            ]);
        }
        return json_encode([
            'status' => false,
            'message' => 'View not added!'
        ]);
    }

    public function getMoviesLike($title='')
    {
        return Movie::where('title', 'like', $title . '%')->with('genre', 'likes')->orderBy('id', 'asc')->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Movie::with('genre', 'likes')->paginate(10);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Movie::whereIn('id', [$id])->with('genre', 'likes')->get();
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
