<?php

namespace App\Models;

use App\Models\Ruang;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PeminjamanRuangan extends Model
{
    use HasFactory;

    protected $primaryKey = 'peminjaman_ruangan_id';

    protected $guarded = [];
    protected $dates = ['tgl_peminjaman'];
    public $timestamps = true;

    public function ruang(){
        return $this->belongsTo(Ruang::class, 'kode_ruang', 'kode_ruang');
    }
}
