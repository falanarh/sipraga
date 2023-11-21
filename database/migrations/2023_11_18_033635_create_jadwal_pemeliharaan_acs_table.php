<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalPemeliharaanAcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwal_pemeliharaan_acs', function (Blueprint $table) {
            $table->bigInteger('nomor');
            $table->id('jadwal_pemeliharaan_ac_id');
            $table->date('tanggal_pelaksanaan');
            $table->string('kode_barang');
            $table->string('nup');
            $table->string('kode_ruang'); // Foreign key
            $table->enum('status', ['Belum Dikerjakan', 'Sedang Dikerjakan', 'Selesai Dikerjakan'])->default('Belum Dikerjakan');
            $table->bigInteger('teknisi_id')->nullable();
            $table->timestamps();
            //Definisi foreign key dengan cascade delete
            $table->foreign(['kode_barang', 'nup'])
                ->references(['kode_barang', 'nup'])
                ->on('asets')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
        Schema::dropIfExists('jadwal_pemeliharaan_acs');
    }
}
