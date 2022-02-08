<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration {

public function up()
{
Schema::create('categories', function(Blueprint $table) {
$table->id();
$table->string('name');
$table->string('slug')->nullable();
$table->string('cover')->nullable();
$table->boolean('status')->default(false);
$table->unsignedBigInteger('parent_id')->nullable();
$table->foreign('parent_id')->references('id')->on('categories')->nullOnDelete();
$table->timestamps();
});
}

public function down()
{
Schema::drop('categories');
}
}