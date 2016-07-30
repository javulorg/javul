<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaypalTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paypal_transaction', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transaction_id')->unsigned()->nullable();
            $table->foreign('transaction_id')->references('id')->on('transactions');
            $table->integer('fund_id')->unsigned()->nullable();
            $table->foreign('fund_id')->references('id')->on('funds');
            $table->text('response');
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
        Schema::drop('paypal_transaction');
    }
}
