<?php

namespace App\Models;

use App\Models\PemeliharaanAc;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JadwalPemeliharaanAc extends Model
{
    use HasFactory;

    protected $primaryKey = 'jadwal_pemeliharaan_ac_id';
    protected $guarded = [];
    protected $dates = ['tanggal_pelaksanaan'];
    public $timestamps = true;

    // Definisi relasi one-to-one dengan model Aset
    public function aset()
    {
        // Sesuaikan dengan primary key dan foreign key yang sesuai
        return $this->belongsTo(Aset::class, ['kode_barang', 'nup'], ['kode_barang', 'nup']);
    }

    // Definisi relasi one-to-one dengan model Ruangs
    public function ruang()
    {
        // Sesuaikan dengan primary key dan foreign key yang sesuai
        return $this->belongsTo(Ruang::class, 'kode_ruang', 'kode_ruang');
    }
    
    // Definisi relasi one-to-one dengan model User
    public function user()
    {
        // Sesuaikan dengan primary key dan foreign key yang sesuai
        return $this->belongsTo(User::class, 'teknisi_id', 'user_id');
    }

    public function pemeliharaanAc()
    {
        return $this->hasOne(PemeliharaanAc::class);
    }
}
