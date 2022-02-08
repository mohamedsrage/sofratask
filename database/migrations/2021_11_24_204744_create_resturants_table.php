<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResturantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resturants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('password')->nullable();
            $table->string('email')->nullable();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->integer('city_id')->nullable();
            $table->integer('neighborhood_id')->nullable();
            $table->string('password_reset')->nullable();
            $table->string('pin_code')->nullable();
            $table->integer('category_id')->nullable();
            $table->string('Minimum_order')->nullable();
            $table->string('Delivery_Charge')->nullable();
            $table->string('contact_information')->nullable();
            $table->string('whats_app')->nullable();
            $table->string('avatar')->nullable();
            $table->string('image')->nullable();
            $table->tinyInteger('avalible')->default('1');
            $table->tinyInteger('blocked')->default('0');
            $table->tinyInteger('active')->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resturants');
    }
}
