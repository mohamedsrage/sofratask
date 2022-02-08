<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration {

public function up()
{
Schema::create('pages', function(Blueprint $table) {
$table->increments('id');
$table->timestamps();
$table->text('name')->nullable();
$table->string('desc')->nullable();
$table->string('ulr')->nullable();
});
}

public function down()
{
Schema::drop('pages');
}
}