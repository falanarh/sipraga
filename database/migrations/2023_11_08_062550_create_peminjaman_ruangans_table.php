<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeminjamanRuangansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('peminjaman_ruangans', function (Blueprint $table) {
        $table->id('peminjaman_ruangan_id');
        $table->bigInteger('nomor');
        $table->string('kode_ruang');
        $table->string('peminjam');
        $table->text('keterangan');
        $table->enum('status', ['Menunggu', 'Disetujui', 'Dialihkan', 'Ditolak'])->default('Menunggu');
        $table->text('tanggapan')->nullable();
        $table->date('tgl_mulai');
        $table->date('tgl_selesai');
        $table->time('waktu_mulai');
        $table->time('waktu_selesai');
        $table->timestamps();
        
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
        Schema::dropIfExists('peminjaman_ruangans');
    }
}
