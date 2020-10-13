<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Material;
use Faker\Generator as Faker;

$factory->define(Material::class, function (Faker $faker) {
    return [
        'name'  => $faker->word,
        'type'  => $faker->numberBetween(0,1),
        'quantity_type'   => $faker->numberBetween(0,1),
        'material_type_id' => factory('App\MaterialType')->create()->id,
    ];
});
