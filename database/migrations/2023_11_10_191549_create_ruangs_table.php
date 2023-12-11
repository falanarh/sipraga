<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRuangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('ruangs', function (Blueprint $table) {
        $table->bigInteger('nomor');
        $table->string('kode_ruang')->primary();
        $table->string('nama')->unique();
        $table->integer('gedung'); // Tambahkan atribut gedung
        $table->integer('lantai'); // Tambahkan atribut lantai
        $table->integer('kapasitas'); // Tambahkan atribut kapasitas
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ruangs');
    }
}
