<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_log', function (Blueprint $table) {
            $table->increments('system_log_id');
            $table->integer('user_id');
            $table->string('ip', 100);
            $table->string('action', 45);
            $table->string('key', 100);
            $table->text('value');
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
        Schema::drop('system_log');
    }
}
