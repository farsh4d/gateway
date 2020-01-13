<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGatewayTransactionsTable extends Migration
{
	function getTable()
	{
		return config('gateway.gateway_config.zarinpal', 'zarinpal_gateway_settings');
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
            $table->string('merchant_id');
            $table->enum('type', ['zarin-gate', 'normal']);
            $table->string('server');
            $table->string('email');
            $table->string('mobile');
            $table->string('description');
            $table->string('callback_url');
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
