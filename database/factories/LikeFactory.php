<?php

use Faker\Generator as Faker;

$factory->define(App\Like::class, function (Faker $faker) {
    return [
        //
        'liked' => rand(1, 2) % 2 === 0 ? 1 : 0,
        'movie_id' => rand(1, 50),
        'user_id' => rand(1, 20)
    ];
});
