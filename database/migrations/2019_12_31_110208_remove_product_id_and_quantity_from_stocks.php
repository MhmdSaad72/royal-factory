<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveProductIdAndQuantityFromStocks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stocks', function (Blueprint $table) {
          $table->dropForeign(['product_id']);
          $table->dropColumn('product_id');
          $table->dropColumn('quantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stocks', function (Blueprint $table) {
          $table->integer('product_id')->unsigned()->nullable();
          $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
          $table->integer('quantity')->nullable();

        });
    }
}
