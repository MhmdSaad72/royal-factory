<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Order;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    return [
      'material_id' => factory('App\Material')->create()->id,
      'supplier_id' => factory('App\Supplier')->create()->id,
      'process_number' => $faker->unique()->randomNumber(5),
      'quantity'=> $faker->randomNumber(3),
      'expire_date' =>$faker->date,

    ];
});
