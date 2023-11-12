<?php

namespace App\Models;

use App\Models\Aset;
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
}
