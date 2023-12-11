<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangHabisPakaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang_habis_pakais', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bhp_id');
            $table->string('jenis_barang');
            $table->integer('jumlah');
            $table->string('satuan');
            $table->enum('jenis_transaksi', ['Masuk', 'Keluar'])->default('Masuk');
            $table->integer('nomor');
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
        Schema::dropIfExists('barang_habis_pakais');
    }
}