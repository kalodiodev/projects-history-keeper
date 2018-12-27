<?php

use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {

    $commentables = [
        \App\Project::class
    ];

    $commentableType = $faker->randomElement($commentables);

    return [
        'comment' => $faker->sentence,
        'user_id' => factory(\App\User::class)->create()->id,
        'commentable_id' => factory($commentableType)->create()->id,
        'commentable_type' => $commentableType,
    ];
});
