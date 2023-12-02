<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengaduansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->id('pengaduan_id');
            $table->string('tiket');
            $table->unsignedBigInteger('pelapor_id');
            $table->string('jenis_barang');
            $table->date('tanggal');
            $table->string('kode_ruang');
            $table->enum('prioritas', ['Rendah', 'Sedang', 'Tinggi'])->default('Rendah');
            $table->enum('status', ['Menunggu', 'Ditolak', 'Dikerjakan', 'Selesai'])->default('Menunggu');
            $table->unsignedBigInteger('teknisi_id')->nullable();
            $table->text('deskripsi');
            $table->string('lampiran');
            $table->text('alasan_ditolak')->nullable();
            $table->timestamps();
            $table->foreign('pelapor_id')
                ->references('user_id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            // $table->foreign(['kode_barang', 'nup'])
            //     ->references(['kode_barang', 'nup'])
            //     ->on('asets')
            //     ->onDelete('cascade')
            //     ->onUpdate('cascade');
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
        Schema::dropIfExists('pengaduans');
    }
}
