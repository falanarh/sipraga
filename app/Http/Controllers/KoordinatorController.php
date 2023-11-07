<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KoordinatorController extends Controller
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

    public function jadwalPengecekanKelas(){
        $userInfo = $this->getUserInfo();
        return view('roles.koordinator.jadwal-pengecekan-kelas-koordinator', compact('userInfo'));
    }

    public function penugasan(){
        $userInfo = $this->getUserInfo();
        return view('roles.koordinator.penugasan-admin', compact('userInfo'));
    }

    public function daftarPengaduan() {
        $userInfo = $this->getUserInfo();
        return view('roles.koordinator.daftar-pengaduan-koordinator', compact('userInfo'));
    }

    public function daftarPengaduanDetail() {
        $userInfo = $this->getUserInfo();
        return view('roles.koordinator.daftar-pengaduan-detail-koordinator', compact('userInfo'));
    }

    public function daftarPerbaikan(){
        $userInfo = $this->getUserInfo();
        return view('roles.koordinator.daftar-perbaikan-koordinator', compact('userInfo'));
    }

    public function daftarPerbaikanDetail(){
        $userInfo = $this->getUserInfo();
        return view('roles.koordinator.daftar-perbaikan-detail-koordinator', compact('userInfo'));
    }
}
