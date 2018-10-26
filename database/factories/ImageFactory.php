<?php

use App\Image;
use Faker\Generator as Faker;

$factory->define(Image::class, function (Faker $faker) {
    $imageables = [
        \App\Project::class
    ];
    
    $imageableType = $faker->randomElement($imageables);

    return [
        'url' => $faker->url,
        'imageable_type' => $imageableType,
        'imageable_id' => factory($imageableType)->create()->id
    ];
});
