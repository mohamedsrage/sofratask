<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNeighborhoodsTable extends Migration {

public function up()
{
Schema::create('neighborhoods', function(Blueprint $table) {
$table->increments('id');
$table->timestamps();
$table->string('name')->nullable();
$table->string('city_id')->nullable();
});
}

public function down()
{
Schema::drop('neighborhoods');
}
}