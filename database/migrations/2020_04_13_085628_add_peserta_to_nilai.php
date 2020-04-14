<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPesertaToNilai extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nilai', function (Blueprint $table) {
            $table->unsignedInteger('peserta_id');
            $table->foreign('peserta_id')->references('id')->on('peserta');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nilai', function (Blueprint $table) {
            //
        });
    }
}
