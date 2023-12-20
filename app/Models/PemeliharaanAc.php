<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\JadwalPemeliharaanAc;

class PemeliharaanAc extends Model
{
    use HasFactory;
    protected $primaryKey = 'pemeliharaan_ac_id';
    protected $guarded = [];
    protected $dates = ['tanggal_selesai'];
    public $timestamps = true;

    // Definisi relasi one-to-one dengan model JadwalPemeliharaanAc
    public function jadwalPemeliharaanAc()
    {
        // Sesuaikan dengan primary key dan foreign key yang sesuai
        return $this->belongsTo(JadwalPemeliharaanAc::class, 'jadwal_pemeliharaan_ac_id', 'jadwal_pemeliharaan_ac_id');
    }
}
