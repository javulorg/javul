<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('unit_id')->unsigned()->nullable();
            $table->foreign('unit_id')->references('id')->on('units');
            $table->integer('objective_id')->unsigned()->nullable();
            $table->foreign('objective_id')->references('id')->on('objectives');
            $table->string('name');
            $table->text('description');
            $table->text('task_action');
            $table->text('task_documents');
            $table->text('summary')->nullable();
            $table->string('skills');
            $table->dateTime('estimated_completion_time_start');
            $table->dateTime('estimated_completion_time_end');
            $table->decimal('compensation',10,2);
            $table->text('updatedFields')->nullable();
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
        Schema::drop('task_history');
    }
}
