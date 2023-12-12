<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanRuangan extends Model
{
    use HasFactory;

    protected $primaryKey = 'ruang_id';
    protected $fillable = [
        'peminjam', 'tgl_peminjaman', 'jam', 'keterangan', 'status', 'keterangan_status'
    ];
}
