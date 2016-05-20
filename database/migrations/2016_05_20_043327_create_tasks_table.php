<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('unit_id')->unsigned();
            $table->foreign('unit_id')->references('id')->on('units');
            $table->integer('objective_id')->unsigned();
            $table->foreign('objective_id')->references('id')->on('objectives');
            $table->string('name');
            $table->string('description');
            $table->string('skills');
            $table->dateTime('estimated_completion_time');
            $table->decimal('reward',10,2);
            $table->text('file_attchments');
            $table->integer('assign_to')->unsigned();
            $table->foreign('assign_to')->references('id')->on('users');
            $table->string('status');
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
        Schema::drop('tasks');
    }
}
