<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePelajaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pelajaran', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('deskripsi')->nullable();
            // $table->string('singkatan');
            // $table->unsignedBigInteger('sekolah_id')->nullable();
            // $table->foreign('sekolah_id')->references('id')->on('sekolah')->onDelete('cascade');
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
        Schema::dropIfExists('pelajaran');
    }
}
