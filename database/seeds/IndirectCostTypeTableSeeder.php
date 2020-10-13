<?php

use Illuminate\Database\Seeder;

class IndirectCostTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\IndirectCostType::class , 3)->create();
    }
}
