<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\JadwalPemeliharaanAc;
use Illuminate\Support\Facades\Auth;

class TeknisiController extends Controller
{
    private function getUserInfo()
    {
        $userInfo = [
            'name' => Auth::user()->name,
            'role' => Auth::user()->role,
            'timeOfDay' => $this->getTimeOfDay(),
        ];
        return $userInfo;
    }

    private function getTimeOfDay()
    {
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

    public function daftarPengaduan()
    {
        $userInfo = $this->getUserInfo();
        return view('roles.teknisi.daftar-pengaduan-teknisi', compact('userInfo'));
    }

    public function daftarPengaduanDetail()
    {
        $userInfo = $this->getUserInfo();
        return view('roles.teknisi.daftar-pengaduan-detail-teknisi', compact('userInfo'));
    }

    public function jadwalPemeliharaan()
    {
        $userInfo = $this->getUserInfo();
        
        return view('roles.teknisi.jadwal-pemeliharaan-teknisi', compact('userInfo'));
    }

    public function pemeliharaan($jadwal_pemeliharaan_ac_id)
    {
        $userInfo = $this->getUserInfo();
        $jadwalPemeliharaanAc = JadwalPemeliharaanAc::where('jadwal_pemeliharaan_ac_id', $jadwal_pemeliharaan_ac_id)->firstOrFail();

        return view('roles.teknisi.pemeliharaan-teknisi', compact('userInfo','jadwalPemeliharaanAc'));
    }

    public function daftarPemeliharaan()
    {
        $userInfo = $this->getUserInfo();
        return view('roles.teknisi.daftar-pemeliharaan-teknisi', compact('userInfo'));
    }

    public function daftarPemeliharaanDetail()
    {
        $userInfo = $this->getUserInfo();
        return view('roles.teknisi.daftar-pemeliharaan-detail-teknisi', compact('userInfo'));
    }

    public function perbaikan()
    {
        $userInfo = $this->getUserInfo();
        return view('roles.teknisi.perbaikan-teknisi', compact('userInfo'));
    }

    public function daftarPerbaikan()
    {
        $userInfo = $this->getUserInfo();
        return view('roles.teknisi.daftar-perbaikan-teknisi', compact('userInfo'));
    }

    public function daftarPerbaikanDetail()
    {
        $userInfo = $this->getUserInfo();
        return view('roles.teknisi.daftar-perbaikan-detail-teknisi', compact('userInfo'));
    }
}
