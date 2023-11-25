<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemeliharaanAcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemeliharaan_acs', function (Blueprint $table) {
            $table->bigInteger('nomor');
            $table->id('pemeliharaan_ac_id');
            $table->bigInteger('jadwal_pemeliharaan_ac_id')->unsigned(); //Foreign key
            // $table->foreign('jadwal_pemeliharaan_ac_id')->references('jadwal_pemeliharaan_ac_id')->on('Jadwal_Pemeliharaan_AC');
            $table->date('tanggal_selesai');
            $table->string('judul_pemeliharaan');
            $table->string('judul_perbaikan');
            $table->text('keterangan');
            $table->string('file_path')->nullable();
            $table->timestamps();
            //Definisi foreign key dengna cascade delete
            $table->foreign('jadwal_pemeliharaan_ac_id')
                ->references('jadwal_pemeliharaan_ac_id')
                ->on('jadwal_pemeliharaan_acs')
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
        Schema::dropIfExists('pemeliharaan_acs');
    }
}
