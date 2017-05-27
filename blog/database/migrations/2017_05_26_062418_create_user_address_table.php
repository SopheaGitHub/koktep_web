<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_address', function (Blueprint $table) {
            $table->increments('user_address_id');
            $table->integer('user_id');
            $table->string('firstname', 32);
            $table->string('lastname', 32);
            $table->string('company', 100);
            $table->string('phone', 100);
            $table->string('fax', 100);
            $table->string('email', 100);
            $table->string('website', 100);
            $table->string('address');
            $table->string('city', 128);
            $table->string('postcode', 10);
            $table->integer('country_id');
            $table->integer('zone_id');
            $table->integer('sort_order')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_address');
    }
}
