<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeterkaitanKriteriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keterkaitan_kriteria', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('kriteria_x');
            $table->unsignedInteger('kriteria_y');
            $table->boolean('terkait');
            $table->date('tahun_kriteria');
            $table->timestamps();

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
        Schema::dropIfExists('keterkaitan_kriteria');
    }
}
