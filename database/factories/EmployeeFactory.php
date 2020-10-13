<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Employee;
use Faker\Generator as Faker;

$factory->define(Employee::class, function (Faker $faker) {
    return [
        'name'  => $faker->name,
        // 'precentage'  => $faker->randomNumber(2),
        'salary'=> $faker->randomNumber(3),
        // 'type' => $faker->numberBetween(0,1),
        'position_id' => factory('App\PositionType')->create()->id,
    ];
});
