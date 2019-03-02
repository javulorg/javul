<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateZcashTransactionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('zcash_transaction', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('fund_id')->unsigned()->nullable()->index('coinbase_transaction_fund_id_foreign');
			$table->integer('user_transaction_id')->nullable();
			$table->text('transaction_id', 65535)->nullable()->comment('zcash transaction id');
			$table->text('amount', 65535)->nullable();
			$table->text('zcash_address', 65535)->nullable();
			$table->string('status')->nullable()->comment('success,pending,cancel');
			$table->text('qr_code', 65535)->nullable();
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
		Schema::drop('zcash_transaction');
	}

}
