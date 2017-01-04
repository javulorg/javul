<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class TasksRevisions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks_revisions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('unit_id')->unsigned();
            $table->integer('task_id')->unsigned();
            $table->integer('objective_id')->unsigned();
            $table->string('name',255);
            $table->text('description');
            $table->string('size',10);
            $table->string('comment',255);
            $table->text('task_action');
            $table->text('summary');
            $table->string('skills',255);
            $table->dateTime('estimated_completion_time_start');
            $table->dateTime('estimated_completion_time_end');
            $table->decimal('compensation',10,2);
            $table->integer('assign_to')->unsigned();
            $table->string('status',255);
            $table->integer('modified_by')->unsigned();
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
            $table->dateTime('deleted_at');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tasks_revisions');
    }
}
