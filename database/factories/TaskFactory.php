<?php

use Faker\Generator as Faker;

$factory->define(\App\Task::class, function (Faker $faker) {
    return [
        'title'       => $faker->sentence(4),
        'description' => $faker->sentence(8),
        'date'        => $faker->date('Y-m-d'),
        'project_id'  => factory(\App\Project::class)->create()->id,
        'user_id'     => factory(\App\User::class)->create()->id
    ];
});
