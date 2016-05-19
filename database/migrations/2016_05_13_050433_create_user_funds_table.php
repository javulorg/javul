<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserFundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_funds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users');
            $table->integer('user_from_id')->unsigned();
            $table->foreign('user_from_id')->references('id')->on('users');
            $table->integer('user_to_id')->unsigned();
            $table->foreign('user_to_id')->references('id')->on('users');
            $table->decimal('amount',10,2);
            $table->string('type',20)->comment = "donated or rewarded";
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
        Schema::drop('user_funds');
    }
}
