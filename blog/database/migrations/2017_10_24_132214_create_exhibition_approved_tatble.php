<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExhibitionApprovedTatble extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exhibition_approved', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('exhibition_id');
            $table->text('requested_id');
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
        Schema::drop('exhibition_approved');
    }
}
