<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGatewayTransactionsTable extends Migration
{
	function getTable()
	{
		return config('gateway.gateway_config.paypal', 'paypal_gateway_configs');
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
            $table->string('default_product_name');
            $table->string('default_shipment_price');
            $table->string('client_id');
            $table->string('secret');
            $table->string('setting_id');
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
