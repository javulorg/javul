<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateZcashWithdrawRequestTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('zcash_withdraw_request', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned()->index('coinbase_transaction_user_id_foreign');
			$table->integer('user_transaction_id');
			$table->text('transfer_transaction_id', 65535)->nullable();
			$table->text('amount', 65535);
			$table->text('zcash_address', 65535);
			$table->string('status', 100)->comment('withdrawal,rejected,approved');
			$table->text('transaction_data', 65535)->nullable();
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
		Schema::drop('zcash_withdraw_request');
	}

}
