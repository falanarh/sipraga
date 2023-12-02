<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class perbaikan extends Model
{
    use HasFactory;

    protected $primaryKey = 'perbaikan_id';
    protected $guarded = [];
    protected $dates = ['tanggal_selesai'];
    public $timestamps = true;
   
    public function asetByKodeBarangAndByNUP()
    {
        // Sesuaikan dengan primary key dan foreign key yang sesuai
        return $this->belongsTo(Aset::class, ['kode_barang', 'nup'], ['kode_barang','nup']);
    }

    public function pengaduan(){
        return $this->belongsTo(Pengaduan::class, 'pengaduan_id', 'pengaduan_id');
    }
}
