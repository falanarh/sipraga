<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengecekanKelasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengecekan_kelas', function (Blueprint $table) {
            $table->id('pengecekan_kelas_id');
            $table->bigInteger('nomor');
            $table->date('tanggal');
            $table->string('kode_ruang');
            $table->enum('status', ['Belum Dikerjakan', 'Sudah Dikerjakan'])->default('Belum Dikerjakan');
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->timestamps();
            $table->foreign('kode_ruang')
                ->references('kode_ruang')
                ->on('ruangs')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('admin_id')
                ->references('user_id')
                ->on('users')
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
        Schema::dropIfExists('pengecekan_kelas');
    }
}
