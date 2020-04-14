<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKriteriaToBobotPrioritas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bobot_prioritas', function (Blueprint $table) {
            $table->unsignedInteger('kriteria_id');
            $table->foreign('kriteria_id')->references('id')->on('kriteria');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bobot_prioritas', function (Blueprint $table) {
            //
        });
    }
}
