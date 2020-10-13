<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialOutcomeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_outcome', function (Blueprint $table) {
          $table->increments('id');
          $table->timestamps();
          $table->integer('quantity')->nullable();
          $table->softDeletes();

          $table->integer('material_id')->unsigned();
          $table->foreign('material_id')->references('id')->on('materials')->onDelete('cascade');

          $table->integer('outcome_id')->unsigned();
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
        Schema::dropIfExists('material_outcome');
    }
}
