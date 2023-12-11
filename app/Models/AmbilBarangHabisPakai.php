<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AmbilBarangHabisPakai extends Model
{
    use HasFactory;

    protected $primaryKey = 'pengambilan_bhp_id';
    protected $guarded = [];
    public $timestamps = true;

    public function ruang()
    {
        return $this->belongsTo(Ruang::class, 'kode_ruang', 'nama');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'pemakai_bhp_id', 'user_id');
    }
}
