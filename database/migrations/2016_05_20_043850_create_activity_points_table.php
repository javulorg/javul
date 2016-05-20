<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_points', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->integer('unit_id')->nullable();
            $table->integer('objective_id')->nullable();
            $table->integer('task_id')->nullable();
            $table->integer('issue_id')->nullable();
            $table->integer('points');
            $table->text('comments');
            $table->string('type')->comment='unit,objective,task or issue';
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
        Schema::drop('activity_points');
    }
}
