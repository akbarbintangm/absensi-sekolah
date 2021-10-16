<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembelajaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembelajaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pelajaran_id');
            $table->foreign('pelajaran_id')->references('id')->on('pelajaran')->onDelete('cascade');
            $table->unsignedBigInteger('jadwal_id');
            $table->foreign('jadwal_id')->references('id')->on('jadwal')->onDelete('cascade');
            $table->unsignedBigInteger('guru_id');
            $table->foreign('guru_id')->references('id')->on('users')->onDelete('cascade');
            // $table->unsignedBigInteger('metode_belajar_id');
            // $table->foreign('metode_belajar_id')->references('id')->on('metode_belajar')->onDelete('cascade');
            $table->unsignedBigInteger('kelas_id');
            $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('cascade');
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
        Schema::dropIfExists('pembelajaran');
    }
}
