<?php

use App\Guide;
use Faker\Generator as Faker;

$factory->define(Guide::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'description' => $faker->sentence,
        'body' => $faker->paragraph,
        'user_id' => function () {
            return factory(\App\User::class)->create()->id;
        }
    ];
});
