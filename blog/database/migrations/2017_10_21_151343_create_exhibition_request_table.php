<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExhibitionRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exhibition_request', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('exhibition_id');
            $table->integer('user_id');
            $table->string('name', 255);
            $table->string('phone', 100);
            $table->integer('category_id');
            $table->string('file', 255);
            $table->string('title', 255);
            $table->text('description');
            $table->integer('sort_order')->default(0);
            $table->integer('status')->default(0);
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
        Schema::drop('exhibition_request');
    }
}
