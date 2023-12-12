<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Aset;
use App\Models\User;
use App\Models\Ruang;
use App\Models\Barang;
use App\Models\BarangHabisPakai;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\AmbilBarangHabisPakai;

class AdminController extends Controller
{
    private function getUserInfo()
    {
        $userInfo = [
            'name' => Auth::user()->name,
            'photo' => Auth::user()->picture_link,
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

    public function ketersediaanRuangan()
    {
        $userInfo = $this->getUserInfo();
        return view('roles.admin.ketersediaan-ruangan-admin', compact('userInfo'));
    }

    public function ketersediaanRuanganDetail()
    {
        $userInfo = $this->getUserInfo();
        return view('roles.admin.ketersediaan-ruangan-detail-admin', compact('userInfo'));
    }

    public function dataRuangan()
    {
        $userInfo = $this->getUserInfo();
        return view('roles.admin.data-ruangan-admin', compact('userInfo'));
    }

    public function editRuangan($kode)
    {
        $userInfo = $this->getUserInfo();
        $ruang = Ruang::find($kode);
        return view('roles.admin.edit-ruangan-admin', compact('userInfo', 'ruang'));
    }

    public function tambahRuangan()
    {
        $userInfo = $this->getUserInfo();
        return view('roles.admin.tambah-ruangan-admin', compact('userInfo'));
    }

    public function pengelolaanPeminjaman()
    {
        $userInfo = $this->getUserInfo();
        return view('roles.admin.pengelolaan-peminjaman-admin', compact('userInfo'));
    }

    public function pengelolaanPeminjamanDetail()
    {
        $userInfo = $this->getUserInfo();
        return view('roles.admin.pengelolaan-peminjaman-detail-admin', compact('userInfo'));
    }

    public function dataMaster()
    {
        $userInfo = $this->getUserInfo();
        $jenisBarangOptions = Barang::all();
        $ruangOptions = Ruang::all();

        return view('roles.admin.data-master-admin', compact('userInfo', 'jenisBarangOptions', 'ruangOptions'));
    }

    public function dataMasterDetail($kode_barang, $nup)
    {
        $userInfo = $this->getUserInfo();
        $aset = Aset::where('kode_barang', $kode_barang)
            ->where('nup', $nup)
            ->firstOrFail();
        return view('roles.admin.data-master-detail-admin', compact('userInfo', 'aset'));
    }

    public function tambahJenis()
    {
        $userInfo = $this->getUserInfo();
        return view('roles.admin.tambah-jenis-barang-admin', compact('userInfo'));
    }

    public function editJenis($kode_barang)
    {
        $userInfo = $this->getUserInfo();
        $barang = Barang::find($kode_barang);

        return view('roles.admin.edit-jenis-barang-admin', compact('userInfo', 'barang'));
    }

    public function tambahSarpras()
    {
        $userInfo = $this->getUserInfo();
        $jenisBarangOptions = Barang::all();
        $ruangOptions = Ruang::all();

        return view('roles.admin.tambah-sarpras-admin', compact('userInfo', 'jenisBarangOptions', 'ruangOptions'));
    }

    public function editSarpras($kode_barang, $nup)
    {
        $userInfo = $this->getUserInfo();
        $jenisBarangOptions = Barang::all();
        $ruangOptions = Ruang::all();
        $aset = Aset::where('kode_barang', $kode_barang)
            ->where('nup', $nup)
            ->firstOrFail();

        return view('roles.admin.edit-sarpras-admin', compact('userInfo', 'jenisBarangOptions', 'ruangOptions', 'aset'));
    }

    public function jadwalPengecekanKelas()
    {
        $userInfo = $this->getUserInfo();
        return view('roles.admin.jadwal-pengecekan-kelas-admin', compact('userInfo'));
    }

    public function barangHabisPakai()
    {       
        $userInfo = $this->getUserInfo();
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'PemakaiBHP');
        })->get();
        $ruangOptions = Ruang::all();
        // dd($users);        
        $bhps = BarangHabisPakai::select([
            'jenis_barang'])
            ->groupBy('jenis_barang')
            ->get();
        $ambil_bhps = AmbilBarangHabisPakai::select([
            'jenis_barang'])
            ->groupBy('jenis_barang')
            ->get();
        
        return view('roles.admin.barang-habis-pakai-admin', compact('userInfo', 'users', 'bhps','ambil_bhps', 'ruangOptions'));
    }

    

    public function tambahBHP()
    {
        $userInfo = $this->getUserInfo();
        $bhps = BarangHabisPakai::select([
            'jenis_barang'])
            ->groupBy('jenis_barang')
            ->get();

        return view('roles.admin.tambah-bhp-admin', compact('userInfo', 'bhps'));
    }

    public function tambahJenisBHP()
    {
        $userInfo = $this->getUserInfo();
        $bhps = BarangHabisPakai::select([
            'jenis_barang'])
            ->groupBy('jenis_barang')
            ->get();
        return view('roles.admin.tambah-jenis-bhp-admin', compact('userInfo', 'bhps'));
    }

    public function showBhpEditForm($id)
    {
        $userInfo = $this->getUserInfo();
        $bhp = BarangHabisPakai::find($id);
        return view('roles.admin.edit-bhp-admin', compact('userInfo', 'bhp'));
    }

    public function eksporBHP()
    {
        $userInfo = $this->getUserInfo();
        return view('roles.admin.barang-habis-pakai-admin', compact('userInfo'));
    }
}