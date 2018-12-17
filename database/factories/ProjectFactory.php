<?php

use Faker\Generator as Faker;

$factory->define(App\Project::class, function (Faker $faker) {
    return [
        'user_id' => factory(\App\User::class)->create()->id,
        'title' => $faker->sentence(4),
        'description' => $faker->sentence(8),
        'status_id' => factory(\App\Status::class)->create()->id
    ];
});
