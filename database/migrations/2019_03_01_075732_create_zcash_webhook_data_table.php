<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateZcashWebhookDataTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('zcash_webhook_data', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->text('transaction_id', 65535);
			$table->text('zcash_address', 65535)->nullable();
			$table->string('notification_status', 100);
			$table->text('notification_data', 65535)->nullable();
			$table->text('transaction_data', 65535)->nullable()->comment('it comes from wallet transfer details');
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
		Schema::drop('zcash_webhook_data');
	}

}
