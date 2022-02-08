<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatesTable extends Migration {

public function up()
{
Schema::create('rates', function(Blueprint $table) {
$table->increments('id');
$table->timestamps();
$table->string('client_id')->nullable();
$table->string('resturant_id')->nullable();
$table->string('desc')->nullable();
$table->string('order_id')->nullable();
$table->string('rate')->nullable();
});
}

public function down()
{
Schema::drop('rates');
}
}