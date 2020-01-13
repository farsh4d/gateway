<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGatewayTransactionsTable extends Migration
{

    function getTable()
    {
        return config('gateway.gateway_config.asanpardakht', 'asanpardakht_gateway_configs');
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
			$table->string('merchantId');
			$table->string('merchantConfigId');
			$table->string('username');
			$table->string('password');
			$table->string('key');
			$table->string('iv');
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
