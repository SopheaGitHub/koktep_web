<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTechnicalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_technical', function (Blueprint $table) {
            $table->increments('user_technical_id');
            $table->integer('user_id');
            $table->string('skill');
            $table->string('percent');
            $table->float('min_charge', 8, 2);
            $table->float('max_charge', 8, 2);
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
        Schema::drop('user_technical');
    }
}
