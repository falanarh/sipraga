<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengaduan;
use App\Models\Perbaikan;
use App\Models\Ruang;
use App\Models\Barang;

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
        $jenisBarangOptions = Barang::all();
        $ruangOptions = Ruang::all();
        return view('roles.pelapor.form-pengaduan-pelapor', compact('userInfo', 'jenisBarangOptions', 'ruangOptions'));
    }

    public function daftarPengaduan() {
        // Assuming you have a method to retrieve the list of pengaduans
        //$pengaduans = Pengaduan::all(); // Adjust the logic based on your implementation
    
        $userInfo = $this->getUserInfo();
        $ruangOption = Ruang::all();
    
        // Pass the userInfo and pengaduans variables to the view
        return view('roles.pelapor.daftar-pengaduan-pelapor', compact('userInfo', 'ruangOption'));
    }
    
    public function daftarPengaduanDetail($tiket) {
        $userInfo = $this->getUserInfo();
    
        $pengaduan = Pengaduan::where('tiket', $tiket)
            ->leftJoin('perbaikans', 'pengaduans.pengaduan_id', '=', 'perbaikans.pengaduan_id')
            ->leftJoin('ruangs', 'pengaduans.kode_ruang', '=', 'ruangs.kode_ruang') // Add a left join with the 'ruangs' table
            ->select('pengaduans.*', 'perbaikans.kode_barang', 'perbaikans.nup', 'perbaikans.keterangan', 'ruangs.nama as nama_ruang') // Select the 'nama' column from 'ruangs'
            ->firstOrFail();
    
        return view('roles.pelapor.daftar-pengaduan-detail-pelapor', compact('userInfo', 'pengaduan'));
    }
    
    
    
    

}
