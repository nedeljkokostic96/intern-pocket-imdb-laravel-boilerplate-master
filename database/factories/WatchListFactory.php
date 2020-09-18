<?php

use Faker\Generator as Faker;

$factory->define(App\WatchList::class, function (Faker $faker) {
    return [
        'watched' => rand(1, 2) % 2 === 0,
        'movie_id' => rand(1, 50),
        'user_id' => rand(1, 21)
    ];
});
