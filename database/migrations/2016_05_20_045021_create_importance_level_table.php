<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportanceLevelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('importance_level', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('objective_id')->nullable();
            $table->integer('issue_id')->nullable();
            $table->string('importance_level')->nullable();
            $table->integer('importance_upvote')->nullable();
            $table->integer('importance_downvote')->nullable();
            $table->string('type')->comment="objective or issue";
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
        Schema::drop('importance_level');
    }
}
