<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataRecenzjisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_recenzjis', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pages_id')->unsigned();
            $table->date('data');
            $table->timestamps();
        });

        Schema::table('data_recenzjis', function (Blueprint $table) {
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
        Schema::dropIfExists('data_recenzjis');
    }
}
