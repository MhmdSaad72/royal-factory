<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        // $this->call(MaterialTypeTableSeeder::class);
        // $this->call(OutcomeTableSeeder::class);
        $this->call(ProductTableSeeder::class);
        // $this->call(MaterialsTableSeeder::class);
        $this->call(SupplierTableSeeder::class);
        // $this->call(OrderTableSeeder::class);
        // $this->call(PositionTypeTableSeeder::class);
        // $this->call(EmployeeTableSeeder::class);
        // $this->call(IndirectCostTypeTableSeeder::class);
        // $this->call(IndirectCostTableSeeder::class);
        //
         $this->call(MaterialsTableSeeder::class);
         $this->call(MaterialTypesTableSeeder::class);
    }
}
