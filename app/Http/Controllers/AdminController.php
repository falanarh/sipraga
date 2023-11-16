<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Aset;
use App\Models\Ruang;
use App\Models\Barang;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
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

    public function ketersediaanRuangan(){
        $userInfo = $this->getUserInfo();
        return view('roles.admin.ketersediaan-ruangan-admin', compact('userInfo'));
    }

    public function ketersediaanRuanganDetail(){
        $userInfo = $this->getUserInfo();
        return view('roles.admin.ketersediaan-ruangan-detail-admin', compact('userInfo'));
    }
        
    public function dataRuangan(){
        $userInfo = $this->getUserInfo();
        return view('roles.admin.data-ruangan-admin', compact('userInfo'));
    }

    public function editRuangan($kode){
        $userInfo = $this->getUserInfo();
        $ruang = Ruang::find($kode);
        return view('roles.admin.edit-ruangan-admin', compact('userInfo', 'ruang'));
    }

    public function tambahRuangan(){
        $userInfo = $this->getUserInfo();
        return view('roles.admin.tambah-ruangan-admin', compact('userInfo'));
    }

    public function pengelolaanPeminjaman(){
        $userInfo = $this->getUserInfo();
        return view('roles.admin.pengelolaan-peminjaman-admin', compact('userInfo'));
    }

    public function pengelolaanPeminjamanDetail(){
        $userInfo = $this->getUserInfo();
        return view('roles.admin.pengelolaan-peminjaman-detail-admin', compact('userInfo'));
    }

    public function dataMaster(){
        $userInfo = $this->getUserInfo();
        $jenisBarangOptions = Barang::all();
        $ruangOptions = Ruang::all();

        return view('roles.admin.data-master-admin', compact('userInfo', 'jenisBarangOptions', 'ruangOptions'));
    }

    public function dataMasterDetail($kode_barang, $nup){
        $userInfo = $this->getUserInfo();
        $aset = Aset::where('kode_barang', $kode_barang)
            ->where('nup', $nup)
            ->firstOrFail();
        return view('roles.admin.data-master-detail-admin', compact('userInfo', 'aset'));
    }

    public function tambahJenis() {
        $userInfo = $this->getUserInfo();
        return view('roles.admin.tambah-jenis-barang-admin', compact('userInfo'));
    }

    public function editJenis($kode_barang) {
        $userInfo = $this->getUserInfo();
        $barang = Barang::find($kode_barang);
    
        return view('roles.admin.edit-jenis-barang-admin', compact('userInfo', 'barang'));
    }   

    public function tambahSarpras(){
        $userInfo = $this->getUserInfo();
        $jenisBarangOptions = Barang::all();
        $ruangOptions = Ruang::all();

        return view('roles.admin.tambah-sarpras-admin', compact('userInfo', 'jenisBarangOptions', 'ruangOptions'));
    }

    public function editSarpras($kode_barang, $nup){
        $userInfo = $this->getUserInfo();
        $jenisBarangOptions = Barang::all();
        $ruangOptions = Ruang::all();
        $aset = Aset::where('kode_barang', $kode_barang)
            ->where('nup', $nup)
            ->firstOrFail();

        return view('roles.admin.edit-sarpras-admin', compact('userInfo', 'jenisBarangOptions', 'ruangOptions', 'aset'));
    }

    public function jadwalPengecekanKelas(){
        $userInfo = $this->getUserInfo();
        return view('roles.admin.jadwal-pengecekan-kelas-admin', compact('userInfo'));
    }

    public function barangHabisPakai(){
        $userInfo = $this->getUserInfo();
        return view('roles.admin.barang-habis-pakai-admin', compact('userInfo'));
    }

    public function tambahBHP(){
        $userInfo = $this->getUserInfo();
        return view('roles.admin.tambah-bhp-admin', compact('userInfo'));
    }
}

// class AdminController extends Controller
// {
//     public function ketersediaanRuangan(){
//         return view('roles.admin.ketersediaan-ruangan-admin');
//     }
    
//     public function ketersediaanRuanganDetail(){
//         return view('roles.admin.ketersediaan-ruangan-detail-admin');
//     }
        
//     public function dataRuangan(){
//         return view('roles.admin.data-ruangan-admin');
//     }

//     public function editRuangan(){
//         return view('roles.admin.edit-ruangan-admin');
//     }

//     public function tambahRuangan(){
//         return view('roles.admin.tambah-ruangan-admin');
//     }

//     public function pengelolaanPeminjaman(){
//         return view('roles.admin.pengelolaan-peminjaman-admin');
//     }

//     public function pengelolaanPeminjamanDetail(){
//         return view('roles.admin.pengelolaan-peminjaman-detail-admin');
//     }

//     public function dataMaster(){
//         return view('roles.admin.data-master-admin');
//     }

//     public function dataMasterDetail(){
//         return view('roles.admin.data-master-detail-admin');
//     }

//     public function tambahSarpras(){
//         return view('roles.admin.tambah-sarpras-admin');
//     }

//     public function editSarpras(){
//         return view('roles.admin.edit-sarpras-admin');
//     }

//     public function jadwalPengecekanKelas(){
//         return view('roles.admin.jadwal-pengecekan-kelas-admin');
//     }

//     public function barangHabisPakai(){
//         return view('roles.admin.barang-habis-pakai-admin');
//     }

//     public function tambahBHP(){
//         return view('roles.admin.tambah-bhp-admin');
//     }
// }
