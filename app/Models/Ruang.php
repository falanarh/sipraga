<?php

namespace App\Models;

use App\Models\Aset;
use App\Models\PengecekanKelas;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ruang extends Model
{
    use HasFactory;

    protected $primaryKey = 'kode_ruang';
    protected $guarded = [];
    public $timestamps = false;

    // Definisi relasi one-to-many dengan model Aset
    public function asets()
    {
        return $this->hasMany(Aset::class);
    }

    public function pengecekanKelass()
    {
     return $this->hasMany(PengecekanKelas::class, 'kode_ruang', 'kode_ruang');
    }

    public function jadwalPemeliharaanAcs()
    {
        return $this->hasMany(JadwalPemeliharaanAc::class, 'kode_ruang', 'kode_ruang');
    }
}
