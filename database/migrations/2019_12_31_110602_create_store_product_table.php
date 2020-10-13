<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_product', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('quantity')->nullable();
          $table->integer('code_number')->nullable();
          $table->timestamps();
          $table->softDeletes();

          $table->integer('product_id')->unsigned()->nullable();
          $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

          $table->integer('store_id')->unsigned()->nullable();
          $table->foreign('store_id')->references('id')->on('stocks')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_product');
    }
}
