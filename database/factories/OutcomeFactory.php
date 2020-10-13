<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Outcome;
use Faker\Generator as Faker;

$factory->define(Outcome::class, function (Faker $faker) {
    return [
        'process_number'=> $faker->unique()->randomNumber(5),
    ];
});
