<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PelaporController extends Controller
{   
    private function getUserInfo() {
        $userInfo = [
            'name' => Auth::user()->name,
            'role' => Auth::user()->role,
            'timeOfDay' => $this->getTimeOfDay(),
        ];
        return $userInfo;
    }

    private function getTimeOfDay() {
        $now = Carbon::now('Asia/Jakarta'); // Set zona waktu ke WIB
        $hour = $now->hour;

        if ($hour >= 5 && $hour < 12) {
            return "Pagi";
        } elseif ($hour >= 12 && $hour < 17) {
            return "Siang";
        } elseif ($hour >= 17 && $hour < 20) {
            return "Sore";
        } else {
            return "Malam";
        }
    }
    
    public function buatPengaduan() {
        $userInfo = $this->getUserInfo();
        return view('roles.pelapor.form-pengaduan-pelapor', compact('userInfo'));
    }

    public function daftarPengaduan() {
        $userInfo = $this->getUserInfo();
        return view('roles.pelapor.daftar-pengaduan-pelapor', compact('userInfo'));
    }

    public function daftarPengaduanDetail() {
        $userInfo = $this->getUserInfo();
        return view('roles.pelapor.daftar-pengaduan-detail-pelapor', compact('userInfo'));
    }
}
