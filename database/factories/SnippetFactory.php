<?php

use Faker\Generator as Faker;

$factory->define(\App\Snippet::class, function (Faker $faker) {
    return [
        'title'       => $faker->words(4),
        'description' => $faker->words(6),
        'code'        => $faker->sentences(12),
        'user_id'     => function () {
            return factory(App\User::class)->create()->id;
        }
    ];
});
