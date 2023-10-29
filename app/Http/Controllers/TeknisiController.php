<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeknisiController extends Controller
{
    public function daftarPengaduan(){
        return view('roles.teknisi.daftar-pengaduan-teknisi');
    }
}
