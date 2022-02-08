<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration {

public function up()
{
Schema::create('services', function(Blueprint $table) {
$table->increments('id');
$table->timestamps();
$table->string('image')->nullable();
$table->string('name')->nullable();
$table->string('desc')->nullable();
$table->string('user_id')->nullable();
$table->string('category_id')->nullable();
$table->string('duration')->nullable();
$table->string('price')->nullable();
$table->string('offer_price')->nullable();
});
}

public function down()
{
Schema::drop('services');
}
}