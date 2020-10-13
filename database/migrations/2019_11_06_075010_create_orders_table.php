<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->integer('process_number');
            $table->integer('quantity')->nullable();
            // $table->integer('price')->nullable();
            // $table->text('details')->nullable();
            $table->date('expire_date')->nullable();

            $table->integer('material_id')->unsigned()->nullable();
            $table->foreign('material_id')->references('id')->on('materials')->onDelete('cascade');

            $table->integer('supplier_id')->unsigned()->nullable();
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');

            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('orders');
    }
}
