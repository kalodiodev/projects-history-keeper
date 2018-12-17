<?php

use Faker\Generator as Faker;

$factory->define(\App\Status::class, function (Faker $faker) {
    return [
        'title' => $faker->words(1, true),
        'color' => $faker->hexColor
    ];
});
