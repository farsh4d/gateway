<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGatewayTransactionsTable extends Migration
{
	function getTable()
	{
		return config('gateway.gateway_config.paypal_settings', 'paypal_gateway_settings');
	}

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		Schema::create($this->getTable(), function (Blueprint $table) {
			$table->engine = "innoDB";
            $table->unsignedBigInteger('id', true);
            $table->enum('mode', ['sandbox', 'live']);
            $table->integer('http_ConnectionTimeOut');
            $table->boolean('log_LogEnabled');
            $table->string('log_FileName');
            $table->string('call_back_url');
            $table->string('log_LogLevel');
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
		Schema::drop($this->getTable());
	}
}
