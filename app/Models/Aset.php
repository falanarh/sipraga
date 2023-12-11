<?php

namespace App\Models;

use App\Models\Ruang;
use App\Models\Barang;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Aset extends Model
{
    use HasFactory;

    protected $primaryKey = ['kode_barang', 'nup'];
    public $incrementing = false;   
    protected $guarded = [];
    protected $dates = ['tanggal_masuk', 'tanggal_pemeliharaan_terakhir'];
    public $timestamps = false;

    // Add this method to set the composite key
    protected function setKeysForSaveQuery($query)
    {
        $query
            ->where('kode_barang', '=', $this->getAttribute('kode_barang'))
            ->where('nup', '=', $this->getAttribute('nup'));

        return $query;
    }

    // Definisi relasi many-to-one dengan model Barang
    public function barang()
    {
        // Sesuaikan dengan primary key dan foreign key yang sesuai
        return $this->belongsTo(Barang::class, 'kode_barang', 'kode_barang');
    }

    public function ruang()
    {
        return $this->belongsTo(Ruang::class, 'kode_ruang', 'kode_ruang');
    }

    public function jadwalPemeliharaanAcs()
    {
        return $this->hasMany(JadwalPemeliharaanAc::class, ['kode_barang', 'nup'], ['kode_barang', 'nup']);
    }

}
