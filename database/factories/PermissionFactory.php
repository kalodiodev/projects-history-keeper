<?php

use App\Permission;
use Faker\Generator as Faker;

$factory->define(Permission::class, function (Faker $faker) {
    return [
        'name'  => $faker->unique()->word,
        'label' => $faker->word
    ];
});
