<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asets', function (Blueprint $table) {
            $table->id('no_aset');
            $table->bigInteger('nomor');
            $table->string('kode_barang');
            $table->string('nup');
            $table->date('tanggal_masuk');
            $table->string('kode_ruang');
            $table->enum('kondisi', ['Baik', 'Rusak'])->default('Baik');
            $table->date('tanggal_pemeliharaan_terakhir')->nullable();
            $table->string('deskripsi');
            //Definisi foreign key dengan cascade delete
            $table->foreign('kode_barang')
                ->references('kode_barang')
                ->on('barangs')
                ->onDelete('cascade');
            //Definisi foreign key dengan cascade delete
            $table->foreign('kode_ruang')
                ->references('kode_ruang')
                ->on('ruangs')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asets');
    }
}
