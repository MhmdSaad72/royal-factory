<?php

use Illuminate\Database\Seeder;

class MaterialTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('material_types')->delete();
        
        \DB::table('material_types')->insert(array (
            0 => 
            array (
                'id' => 1,
                'created_at' => '2019-12-23 10:13:26',
                'updated_at' => '2019-12-23 10:13:26',
                'deleted_at' => NULL,
                'name' => 'مواد خام',
            ),
            1 => 
            array (
                'id' => 2,
                'created_at' => '2019-12-23 10:13:33',
                'updated_at' => '2019-12-23 10:13:33',
                'deleted_at' => NULL,
                'name' => 'برطمان',
            ),
            2 => 
            array (
                'id' => 3,
                'created_at' => '2019-12-23 10:13:45',
                'updated_at' => '2019-12-23 10:13:45',
                'deleted_at' => NULL,
                'name' => 'غطاء',
            ),
            3 => 
            array (
                'id' => 4,
                'created_at' => '2019-12-23 10:13:58',
                'updated_at' => '2019-12-23 10:13:58',
                'deleted_at' => NULL,
                'name' => 'بلاستيك',
            ),
            4 => 
            array (
                'id' => 5,
                'created_at' => '2019-12-24 15:50:03',
                'updated_at' => '2019-12-24 15:50:03',
                'deleted_at' => NULL,
                'name' => 'استيكر',
            ),
            5 => 
            array (
                'id' => 6,
                'created_at' => '2019-12-24 15:51:05',
                'updated_at' => '2019-12-24 15:51:05',
                'deleted_at' => NULL,
                'name' => 'كرتون',
            ),
            6 => 
            array (
                'id' => 7,
                'created_at' => '2019-12-25 11:31:12',
                'updated_at' => '2019-12-25 11:31:12',
                'deleted_at' => NULL,
                'name' => 'علبة كرتون',
            ),
            7 => 
            array (
                'id' => 8,
                'created_at' => '2020-01-02 11:44:04',
                'updated_at' => '2020-01-02 11:44:22',
                'deleted_at' => '2020-01-02 11:44:22',
                'name' => 'ثثقثق',
            ),
            8 => 
            array (
                'id' => 9,
                'created_at' => '2020-01-02 11:44:07',
                'updated_at' => '2020-01-02 11:44:20',
                'deleted_at' => '2020-01-02 11:44:20',
                'name' => 'قثقثقبق',
            ),
            9 => 
            array (
                'id' => 10,
                'created_at' => '2020-01-02 11:44:10',
                'updated_at' => '2020-01-02 11:44:19',
                'deleted_at' => '2020-01-02 11:44:19',
                'name' => 'قبثقببببب',
            ),
            10 => 
            array (
                'id' => 11,
                'created_at' => '2020-01-02 11:44:13',
                'updated_at' => '2020-01-02 11:44:17',
                'deleted_at' => '2020-01-02 11:44:17',
                'name' => 'ثقبثبث',
            ),
        ));
        
        
    }
}