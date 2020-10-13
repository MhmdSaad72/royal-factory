<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\IndirectCost;
use Faker\Generator as Faker;

$factory->define(IndirectCost::class, function (Faker $faker) {
    return [
      'reason'=>$faker->sentence,
      'price' => $faker->randomNumber(3),
      'indirect_cost_type_id' => factory('App\IndirectCost')->create()->id,
    ];
});
