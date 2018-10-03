<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutorzyArtykulowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autorzy_artykulows', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('users_id')->unsigned();
            $table->integer('pages_id')->unsigned();
            $table->timestamps();
        });


        Schema::table('autorzy_artykulows', function (Blueprint $table) {
            $table->foreign('users_id')
                ->references('id')
                ->on('users');
        });

        Schema::table('autorzy_artykulows', function (Blueprint $table) {
            $table->foreign('pages_id')
                ->references('id')
                ->on('pages');
        });


    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('autorzy_artykulows');
    }
}
