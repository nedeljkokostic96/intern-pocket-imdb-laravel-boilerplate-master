<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Movie;
use App\Genre;
use App\Mail\MovieCreated;
use App\Jobs\SendEmail;
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
        $movies = Movie::with('genre', 'likes', 'image')->get();
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
        return Movie::where('genre_id', '=', $genreId)->with('genre', 'likes', 'image')->get();
        
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
        return Movie::where('title', 'like', $title . '%')->with('genre', 'likes', 'image')->orderBy('id', 'asc')->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Movie::with('genre', 'likes', 'watchLists', 'image')->paginate(10);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    private function getGenreId($genreName) 
    {
        $genreId = 1;
        $genre = Genre::where('name', '=', $genreName)->limit(1)->get();
        if ($genre && count($genre) === 1) {
            $genreId= $genre[0]->id;
        }else {
            $genre = new Genre();
            $genre->name = $genreName;
            $genre->save();
            $saved = Genre::where('name', '=', $genre->name)->get();
            $genreId = $saved[0]->id;
        }
        return $genreId;
    }

    private function getImageUrl($image) 
    {
        $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
        \Image::make($image)->resize(300, 300)->save(public_path('images/thumbnails/').$name);
        \Image::make($image)->resize(500, 500)->save(public_path('images/full-size/').$name);
        return $name;
    }

    public function store(Request $request)
    {   
        Log::alert($request);
        Log::alert('ENTERED TO PICTURES');
        Log::alert('ENTERED TO PICTURES');
        Log::alert('ENTERED TO PICTURES');
        Log::alert('ENTERED TO PICTURES');
        $movie = new Movie();
        $movie->title = $request->title;
        $movie->description = $request->description;
        $movie->image_url = $request->image_url !== NULL ? $request->image_url : '';
        $movie->genre_id = $request->genre_id !== NULL ? $request->genre_id : $this->getGenreId($request->genre);
        if ($movie->save()) {
            //Mail::to('example@example.com')->send(new MovieCreated($movie)); //previous task
            if ($request->image_url === NULL) {
                Log::alert('ENTERED TO PICTURES');
                $path = $this->getImageUrl($request->image);
                $domain = 'localhost:8000/images/';
                $image = new \App\Image();
                $image->thumbnail = $domain + 'thumbnail/' + $path;
                $image->full_size = $domain + 'full_size/' + $path;
                $image->movie_id = $movie->id;
                $image->save();
            }
            dispatch(new SendEmail($movie));
            return json_encode([
                'status' => true,
                'message' => 'New movie added!'
            ]);
        }
        return json_encode([
            'status' => false,
            'message' => 'Movie not added!'
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
