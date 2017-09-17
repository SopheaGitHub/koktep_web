<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostVisitorViewDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_visitor_view_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('post_id')->default(0);
            $table->integer('visitor_id')->default(0);
            $table->string('ip', 40);
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
        Schema::drop('post_visitor_view_detail');
    }
}
