<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecenzenciArtykulowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recenzenci_artykulows', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('users_id')->unsigned();
            $table->integer('pages_id')->unsigned();
            $table->integer('recenzja_id')->nullable()->unsigned();
            $table->integer('status');
            $table->integer('id_rodzica');
            $table->timestamps();
        });

        Schema::table('recenzenci_artykulows', function (Blueprint $table) {
            $table->foreign('recenzja_id')
                ->references('id')
                ->on('opinias');
        });

        Schema::table('recenzenci_artykulows', function (Blueprint $table) {
            $table->foreign('users_id')
                ->references('id')
                ->on('users');
        });

        Schema::table('recenzenci_artykulows', function (Blueprint $table) {
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
        Schema::dropIfExists('recenzenci_artykulows');
    }
}
