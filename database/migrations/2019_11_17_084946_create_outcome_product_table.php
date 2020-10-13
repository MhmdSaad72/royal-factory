<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOutcomeProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outcome_product', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('quantity')->nullable();
          $table->timestamps();
          $table->softDeletes();

          $table->integer('product_id')->unsigned()->nullable();
          $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

          $table->integer('outcome_id')->unsigned()->nullable();
          $table->foreign('outcome_id')->references('id')->on('outcomes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('outcome_product');
    }
}
