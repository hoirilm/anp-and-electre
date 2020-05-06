<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXyKriteriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xy_kriteria', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('prioritas');
            $table->integer('nilai');
            $table->unsignedInteger('kriteria_x');
            $table->unsignedInteger('kriteria_y');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('kriteria_x')->references('id')->on('kriteria');
            $table->foreign('kriteria_y')->references('id')->on('kriteria');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('xy_kriteria');
    }
}
