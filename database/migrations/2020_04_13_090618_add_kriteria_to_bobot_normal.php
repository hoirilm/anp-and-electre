<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKriteriaToBobotNormal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bobot_normal', function (Blueprint $table) {
            $table->unsignedInteger('kriteria_id');
            $table->unsignedInteger('jurusan_id');
            $table->foreign('kriteria_id')->references('id')->on('kriteria');
            $table->foreign('jurusan_id')->references('id')->on('jurusan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bobot_normal', function (Blueprint $table) {
            //
        });
    }
}
