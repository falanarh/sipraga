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
            $table->string('kode_barang');
            $table->string('nup');
            $table->bigInteger('nomor');
            $table->string('merek');
            $table->date('tanggal_masuk');
            $table->string('kode_ruang')->nullable();
            $table->enum('kondisi', ['Baik', 'Rusak Ringan', 'Rusak Berat'])->default('Baik');
            $table->date('tanggal_pemeliharaan_terakhir')->nullable();
        $table->string('deskripsi')->nullable();
            $table->primary(['kode_barang', 'nup']);
            //Definisi foreign key dengan cascade delete
            $table->foreign('kode_barang')
                ->references('kode_barang')
                ->on('barangs')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            //Definisi foreign key dengan cascade delete
            $table->foreign('kode_ruang')
                ->references('kode_ruang')
                ->on('ruangs')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
