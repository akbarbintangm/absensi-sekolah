<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTugasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tugas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->longText('deskripsi');
            $table->boolean('tugas')->default(false);
            // $table->integer('bobot');
            $table->unsignedBigInteger('pembelajaran_id');
            $table->foreign('pembelajaran_id')->references('id')->on('pembelajaran')->onDelete('cascade');
            $table->dateTime('batas');
            $table->dateTime('waktu_muncul');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('membaca')->nullable();
            $table->string('mendengar')->nullable();
            $table->string('menonton')->nullable();
            // $table->unsignedBigInteger('metode_belajar_id')->nullable();
            // $table->foreign('metode_belajar_id')->references('id')->on('metode_belajar')->onDelete('cascade');
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
        Schema::dropIfExists('tugas');
    }
}
