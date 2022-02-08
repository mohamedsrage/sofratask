<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration {

public function up()
{
Schema::create('contacts', function(Blueprint $table) {
$table->timestamps();
$table->string('name')->nullable();
$table->string('email')->nullable();
$table->string('phone')->nullable();
$table->string('message')->nullable();
$table->string('type')->nullable();
$table->increments('id')->nullable();
});
}

public function down()
{
Schema::drop('contacts');
}
}