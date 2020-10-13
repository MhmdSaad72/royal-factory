<?php

use Illuminate\Database\Seeder;

class IndirectCostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\IndirectCost::class , 3)->create();
    }
}
