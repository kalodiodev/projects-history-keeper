<?php

use Faker\Generator as Faker;

$factory->define(\App\Snippet::class, function (Faker $faker) {
    return [
        'title'       => $faker->sentence(1),
        'description' => $faker->sentence(2),
        'code'        => $faker->sentence(12),
        'user_id'     => function () {
            return factory(App\User::class)->create()->id;
        }
    ];
});
