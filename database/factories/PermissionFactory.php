<?php

use App\Permission;
use Faker\Generator as Faker;

$factory->define(Permission::class, function (Faker $faker) {
    return [
        'name'  => $faker->word,
        'label' => $faker->word
    ];
});
