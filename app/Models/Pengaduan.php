<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;

    protected $primaryKey = 'pengaduan_id';
    protected $guarded = [];
    protected $dates = ['tanggal'];
    public $timestamps = true;
   
    // public function asetByKodeBarangAndByNUP()
    // {
    //     // Sesuaikan dengan primary key dan foreign key yang sesuai
    //     return $this->belongsTo(Aset::class, ['kode_barang', 'nup'], ['kode_barang','nup']);
    // }

    public function ruang(){
        return $this->belongsTo(Ruang::class, 'kode_ruang', 'kode_ruang');
    }

    public function user(){
        return $this->belongsTo(User::class, 'pelapor_id', 'user_id');
    }
}
