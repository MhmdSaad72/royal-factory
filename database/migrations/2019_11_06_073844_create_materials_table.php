<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('name')->nullable();
            $table->integer('quantity_type')->default(0);
            // $table->text('details')->nullable();
            // $table->date('expire_date')->nullable();
            $table->integer('type')->default(0);

            $table->integer('material_type_id')->unsigned()->nullable();
            $table->foreign('material_type_id')->references('id')->on('material_types')->onDelete('cascade');

            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('materials');
    }
}
