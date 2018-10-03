<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Pages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('plik_miz');
            $table->string('plik_bib');
            $table->string('plik_voc')->nullable();
            $table->integer('status')->unsigned();
            $table->timestamps();
        });
        Schema::table('pages', function (Blueprint $table) {
            $table->foreign('status')
                ->references('id')
                ->on('statuses');
        });

    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pages');
    }
}
