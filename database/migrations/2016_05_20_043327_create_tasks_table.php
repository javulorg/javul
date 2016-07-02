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
            $table->integer('unit_id')->unsigned()->nullable();
            $table->foreign('unit_id')->references('id')->on('units');
            $table->integer('objective_id')->unsigned()->nullable();
            $table->foreign('objective_id')->references('id')->on('objectives');
            $table->string('name');
            $table->string('slug');
            $table->text('description');
            $table->text('task_action');
            $table->text('summary')->nullable();
            $table->string('skills');
            $table->dateTime('estimated_completion_time_start');
            $table->dateTime('estimated_completion_time_end');
            $table->decimal('compensation',10,2);
            $table->integer('assign_to')->unsigned()->nullable();
            $table->foreign('assign_to')->references('id')->on('users');
            $table->string('status');
            $table->integer('modified_by')->nullable();
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
