<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKomentarzsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('komentarzs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('komentarz');
            $table->integer('status');
            $table->integer('pages_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('komentarzs', function (Blueprint $table) {
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
        Schema::dropIfExists('komentarzs');
    }
}
