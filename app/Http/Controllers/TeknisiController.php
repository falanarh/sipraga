<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Aset;
use Illuminate\Http\Request;
use App\Models\PemeliharaanAc;
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
        $pemeliharaanOptions = PemeliharaanAc::all();

        $userInfo = $this->getUserInfo();
        return view('roles.teknisi.daftar-pemeliharaan-teknisi', compact('userInfo', 'pemeliharaanOptions'));
    }

    public function daftarPemeliharaanDetail($pemeliharaan_ac_id)
    {
        $userInfo = $this->getUserInfo();
        $pemeliharaanAc = PemeliharaanAc::find($pemeliharaan_ac_id);

        $ac = Aset::where('kode_barang', $pemeliharaanAc->jadwalPemeliharaanAc->kode_barang)
                    ->where('nup', $pemeliharaanAc->jadwalPemeliharaanAc->nup)
                    ->first();

        return view('roles.teknisi.daftar-pemeliharaan-detail-teknisi', compact('userInfo', 'pemeliharaanAc', 'ac'));
    }

    public function editDaftarPemeliharaanDetail($pemeliharaan_ac_id)
    {
        $userInfo = $this->getUserInfo();
        $pemeliharaanAc = PemeliharaanAc::find($pemeliharaan_ac_id);
        
        return view('roles.teknisi.edit-daftar-pemeliharaan-detail-teknisi', compact('userInfo', 'pemeliharaanAc'));
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
