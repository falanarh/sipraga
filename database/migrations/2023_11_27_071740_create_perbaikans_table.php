<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerbaikansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perbaikans', function (Blueprint $table) {
            $table->id('perbaikan_id');
            $table->unsignedBigInteger('pengaduan_id');
            $table->date('tanggal_selesai');
            $table->string('kode_barang');
            $table->string('nup');
            $table->text('perbaikan');
            $table->text('keterangan');
            $table->string('lampiran_perbaikan');
            $table->timestamps();
            $table->foreign('pengaduan_id')
                ->references('pengaduan_id')
                ->on('pengaduans')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign(['kode_barang', 'nup'])
                ->references(['kode_barang', 'nup'])
                ->on('asets')
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
        Schema::dropIfExists('perbaikans');
    }
}
