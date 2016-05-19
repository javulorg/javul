<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRelatedUnits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('related_units', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('unit_id')->unisigned();
            $table->foreign('unit_id')->references('id')->on('units');
            $table->integer('related_to')->unsigned();
            $table->foreign('related_to')->references('id')->on('units');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('related_units');
    }
}
