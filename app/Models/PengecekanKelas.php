<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengecekanKelas extends Model
{
    use HasFactory;

    protected $primaryKey = 'pengecekan_kelas_id';
    protected $guarded = [];
    protected $dates = ['tanggal'];
    public $timestamps = true;
   
    public function ruang(){
        return $this->belongsTo(Ruang::class, 'kode_ruang', 'kode_ruang');
    }

    public function user(){
        return $this->belongsTo(User::class, 'admin_id', 'user_id');
    }
}
