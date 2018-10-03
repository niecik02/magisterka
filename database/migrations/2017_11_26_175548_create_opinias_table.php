<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOpiniasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opinias', function (Blueprint $table) {
            $table->increments('id');
            $table->string('confidence');
            $table->string('decision');
            $table->string('presentation');
            $table->string('quality_of_formalization');
            $table->string('significance_for_mml');
            $table->text('comments');
            $table->text('comments_editors');
            $table->text('mml_remarks');
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
        Schema::dropIfExists('opinias');
    }
}
