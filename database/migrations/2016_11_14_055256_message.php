<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Message extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('message', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('botID');
            $table->string('updateID');
            $table->string('fromID');
            $table->string('fromUsername');
            $table->datetime('date');
            $table->text('text');
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
        //
        Schema::drop('message');
    }
}
