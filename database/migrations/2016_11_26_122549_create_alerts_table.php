<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alerts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->tinyInteger('account_creation')->default(1);
            $table->tinyInteger('confirmation_email')->default(1);
            $table->tinyInteger('forum_replies')->default(0);
            $table->tinyInteger('watched_items')->default(0);
            $table->tinyInteger('inbox')->default(0);
            $table->tinyInteger('fund_received')->default(0);
            $table->tinyInteger('task_management')->default(0);
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
        Schema::drop('alerts');
    }
}
