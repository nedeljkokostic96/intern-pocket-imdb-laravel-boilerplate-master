<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', 'Auth\AuthController@login');
    Route::post('logout', 'Auth\AuthController@logout');
    Route::post('refresh', 'Auth\AuthController@refresh');
    Route::post('me', 'Auth\AuthController@me');
    Route::post('register', 'Auth\RegisterController@create');
});

Route::apiResource('movies', 'Api\MovieController');

Route::get('movies/like/{title}', 'Api\MovieController@getMoviesLike');
Route::put('movies/views/{movie}', 'Api\MovieController@incrementMovieViews');
Route::get('movies/genre/{genre}', 'Api\MovieController@getMoviesByGenre');
Route::get('movies/hotest/{numOfHotest}', 'Api\MovieController@getHotestMovies');

Route::apiResource('likes', 'Api\LikeController');
Route::get('likes/movie/{movieId}', 'Api\LikeController@getAllReactionsForMovie');

Route::apiResource('genres', 'Api\GenreController');

Route::apiResource('comments', 'Api\CommentController');
Route::get('comments/movie/{movie}', 'Api\CommentController@getCommentsByMovieId');
