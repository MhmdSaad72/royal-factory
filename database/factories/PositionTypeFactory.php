<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\PositionType;
use Faker\Generator as Faker;

$factory->define(PositionType::class, function (Faker $faker) {
    return [
        'name' => $faker->word ,
        'description' => $faker->sentence,
    ];
});
