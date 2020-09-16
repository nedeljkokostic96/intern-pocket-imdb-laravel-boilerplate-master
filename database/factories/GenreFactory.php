<?php

use Faker\Generator as Faker;

$factory->define(App\Genre::class, function (Faker $faker) {
    $genres = ['war', 'drama', 'action', 'thriler', 'comedy', 'history', 'documentary'];
    return [
        'name' => $genres[rand(1, 7)]
    ];
});
