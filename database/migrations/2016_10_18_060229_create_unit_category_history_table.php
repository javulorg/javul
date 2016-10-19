<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnitCategoryHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit_category_history', function (Blueprint $table) {
            $table->increments('id');
            $table->string('prefix_id')->nullable();
            $table->integer('unit_category_id')->nullable();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('name')->nullable();
            $table->integer('parent_id')->nullable();
            $table->string('parent_id_belongs_to',20)->nullable();
            $table->text('category_hierarchy')->nullable();
            $table->string('action_type')->comment='added,deleted or updated';
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('unit_category_history');
    }
}
