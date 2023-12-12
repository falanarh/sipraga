<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmbilBarangHabisPakaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ambil_barang_habis_pakais', function (Blueprint $table) {
            $table->id('pengambilan_bhp_id');
            $table->string('nama_ruang');
            $table->integer('nomor');
            $table->unsignedBigInteger('pemakai_bhp_id');
            $table->bigInteger('bhp_id');
            $table->string('jenis_barang');
            $table->integer('jumlah_ambilBHP');
            $table->string('satuan');
            $table->text('keterangan')->nullable(true);
            $table->enum('jenis_transaksi', ['Masuk', 'Keluar'])->default('Keluar');
            // $table->date('tgl_pengambilan_bhp');
            $table-> timestamps();
            $table->foreign('pemakai_bhp_id')->references('user_id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('nama_ruang')->references('nama')->on('ruangs')->onDelete('cascade')->onUpdate('cascade');
            
        });
            // ->on('ruangs')->onDelete('cascade')->onUpdate('cascade');
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ambil_barang_habis_pakais');
    }
}
