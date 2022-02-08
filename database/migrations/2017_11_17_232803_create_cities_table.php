<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration {

public function up()
{
Schema::create('cities', function(Blueprint $table) {
$table->id();
$table->string('name')->nullable();
// $table->foreignId('state_id')->constrained()->cascadeOnDelete();
$table->unsignedBigInteger('state_id')->nullable();
$table->foreign('state_id')->references('id')->on('states')->nullOnDelete();
$table->boolean('status')->default(false);
$table->timestamps();
});
}

public function down()
{
Schema::drop('cities');
}
}