<?php

use Illuminate\Database\Seeder;

class PositionTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\PositionType::class , 3)->create();
    }
}
