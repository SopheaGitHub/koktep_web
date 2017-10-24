<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExhibitionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exhibition', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('title', 255);
            $table->text('categories');
            $table->timestamp('open_date');
            $table->timestamp('close_date');
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
        Schema::drop('exhibition');
    }
}
