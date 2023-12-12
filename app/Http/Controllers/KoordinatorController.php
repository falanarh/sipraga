<?php

namespace App\Http\Controllers;

use App\Models\PengecekanKelas;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Ruang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KoordinatorController extends Controller
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

    public function jadwalPengecekanKelas()
    {
        $userInfo = $this->getUserInfo();
        return view('roles.koordinator.jadwal-pengecekan-kelas-koordinator', compact('userInfo'));
    }

    public function penugasan($pengecekan_kelas_id)
    {
        $userInfo = $this->getUserInfo();
        // Mengambil semua data pengguna
        $pengecekanKelas = PengecekanKelas::find($pengecekan_kelas_id);
        // Mengambil semua pengguna dengan peran "admin"
        $adminUsers = User::whereHas('roles', function ($query) {
            $query->where('name', 'Admin');
        })->get();
        
        return view('roles.koordinator.penugasan-admin', compact('userInfo', 'adminUsers', 'pengecekanKelas'));
    }

    
    public function daftarPengaduan()
    {
        $userInfo = $this->getUserInfo();
        return view('roles.koordinator.daftar-pengaduan-koordinator', compact('userInfo'));
    }

    public function daftarPengaduanDetail()
    {
        $userInfo = $this->getUserInfo();
        return view('roles.koordinator.daftar-pengaduan-detail-koordinator', compact('userInfo'));
    }

    public function daftarPerbaikan()
    {
        $userInfo = $this->getUserInfo();
        return view('roles.koordinator.daftar-perbaikan-koordinator', compact('userInfo'));
    }

    public function daftarPerbaikanDetail()
    {
        $userInfo = $this->getUserInfo();
        return view('roles.koordinator.daftar-perbaikan-detail-koordinator', compact('userInfo'));
    }

    public function tambahJadwal()
    {
        $userInfo = $this->getUserInfo();
        // Ambil daftar ruang yang sudah memiliki jadwal pengecekan kelas
        $ruangOptions = Ruang::all();
        $ruangOptions2 = Ruang::whereHas('pengecekanKelass')->get();
        return view('roles.koordinator.tambah-jadwal-koordinator', compact('userInfo', 'ruangOptions', 'ruangOptions2'));
    }
}
