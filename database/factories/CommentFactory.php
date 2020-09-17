<?php

use Faker\Generator as Faker;

$factory->define(App\Comment::class, function (Faker $faker) {
    return [
        'body' => $faker->text,
        'movie_id' => rand(1, 50),
        'user_id' => rand(1, 20)
    ];
});
