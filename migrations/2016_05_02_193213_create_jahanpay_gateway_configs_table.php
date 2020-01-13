<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGatewayTransactionsTable extends Migration
{

    function getTable()
    {
        return config('gateway.gateway_config.jahanpay', 'jahanpay_gateway_configs');
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
            $table->string('api');
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
