<?php

use Faker\Generator as Faker;

$factory->define(\App\Invitation::class, function (Faker $faker) {
    return [
        'email' => $faker->email,
        'token' => str_random(25)
    ];
});
