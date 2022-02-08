<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration {

public function up()
{
Schema::create('offers', function(Blueprint $table) {
$table->increments('id');
$table->timestamps();
$table->string('name')->nullable();
$table->string('image')->nullable();
$table->string('desc')->nullable();
$table->string('user_id')->nullable();
$table->string('start_date')->nullable();
$table->string('end_date')->nullable();
});
}

public function down()
{
Schema::drop('offers');
}
}