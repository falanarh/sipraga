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
        $table->id();
        $table->string('ruang_id');
        $table->string('peminjam');
        $table->date('tgl_peminjaman');
        $table->time('jam');
        $table->text('keterangan')->nullable();
        $table->string('status')->default('PENDING');
        $table->text('keterangan_status')->nullable();
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
        Schema::dropIfExists('peminjaman_ruangans');
    }
}
