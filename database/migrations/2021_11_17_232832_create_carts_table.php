<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration {

	public function up()
	{
		Schema::create('carts', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('resturant_id')->nullable();
			$table->string('client_id')->nullable();
			$table->string('section_id')->nullable();
			$table->string('service_id')->nullable();
			$table->string('count')->nullable();
			$table->string('total')->nullable();
			$table->string('delivery')->nullable();
			$table->string('delivery_time')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('carts');
	}
}