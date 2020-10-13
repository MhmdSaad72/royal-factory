<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\IndirectCostType;
use Faker\Generator as Faker;

$factory->define(IndirectCostType::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
    ];
});
