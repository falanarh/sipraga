<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Aset;
use App\Models\User;
use App\Models\Ruang;
use App\Models\Barang;
use App\Models\Pengaduan;
use App\Models\Perbaikan;
use Illuminate\Http\Request;
use App\Models\PemeliharaanAc;
use Illuminate\Support\Facades\DB;
use App\Models\JadwalPemeliharaanAc;
use Illuminate\Support\Facades\Auth;

class TeknisiController extends Controller
{
    private function getUserInfo()
    {
        $userInfo = [
            'name' => Auth::user()->name,
            // 'role' => Auth::user()->role,
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

    public function daftarPengaduan()
    {
        $userInfo = $this->getUserInfo();
        $ruangOption = Ruang::all();
        
        // Get pengaduans for the logged-in teknisi
        // $pengaduans = Pengaduan::where('teknisi_id', Auth::id())->get();

        return view('roles.teknisi.daftar-pengaduan-teknisi', compact('userInfo', 'ruangOption'));
    }

    public function daftarPengaduanDetail($tiket)
    {
        $userInfo = $this->getUserInfo();
        $pengaduans = DB::table('pengaduans')->where('tiket', $tiket)->first();
        // Convert the date string to a Carbon instance
        $pengaduans->tanggal = Carbon::parse($pengaduans->tanggal);
        return view('roles.teknisi.daftar-pengaduan-detail-teknisi', compact('userInfo', 'pengaduans'));
    }

    public function jadwalPemeliharaan()
    {
        $userInfo = $this->getUserInfo();
        $ruangOptions = Ruang::all();
        $teknisiOptions = User::whereHas('roles', function ($query) {
            $query->where('name', 'Teknisi');
        })->get(); 
        
        return view('roles.teknisi.jadwal-pemeliharaan-teknisi', compact('userInfo', 'ruangOptions', 'teknisiOptions'));
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

    public function perbaikan($tiket)
    {
        $pengaduan = Pengaduan::where('tiket', $tiket)->firstOrFail();
        $jenisBarang = $pengaduan->jenis_barang; // Assuming jenis_barang is a column in the Pengaduan model

        // Get unique kode_barang values based on jenis_barang
        $kodeBarangOptions = Barang::where('nama', $jenisBarang)->pluck('kode_barang')->unique();

        // Get unique nup values based on kode_barang
        $nupOptions = Aset::where('kode_barang', $kodeBarangOptions)->pluck('nup')->unique();

        $userInfo = $this->getUserInfo();

        return view('roles.teknisi.perbaikan-teknisi', compact('userInfo', 'pengaduan', 'kodeBarangOptions', 'nupOptions'));
    }

    public function daftarPerbaikan()
    {
        $userInfo = $this->getUserInfo();
        $ruangOption = Ruang::all();
        // $perbaikans = Perbaikan::join('pengaduans', 'perbaikans.pengaduan_id', '=', 'pengaduans.pengaduan_id')
        //     ->select('perbaikans.*', 'pengaduans.tiket', 'pengaduans.tanggal', 'pengaduans.jenis_barang', 'pengaduans.teknisi_id', 'pengaduans.kode_ruang')
        //     ->get();
        return view('roles.teknisi.daftar-perbaikan-teknisi', compact('userInfo','ruangOption'));
    }

    public function daftarPerbaikanDetail($tiket)
    {
        $userInfo = $this->getUserInfo();
        $perbaikan = Perbaikan::join('pengaduans', 'perbaikans.pengaduan_id', '=', 'pengaduans.pengaduan_id')
        ->where('pengaduans.tiket', $tiket)
        ->select(
            'perbaikans.*',  // Select all columns from the Perbaikan table
            'pengaduans.tiket',
            'pengaduans.jenis_barang',
            'pengaduans.teknisi_id',  // Select the teknisi column from the Pengaduan table
            'pengaduans.kode_ruang'  // Select the kode_ruang column from the Pengaduan table
        )
        ->first();

        return view('roles.teknisi.daftar-perbaikan-detail-teknisi', compact('userInfo','perbaikan'));
    }

    public function editPerbaikan($tiket)
    {
        $userInfo = $this->getUserInfo();
        $perbaikan = Perbaikan::join('pengaduans', 'perbaikans.pengaduan_id', '=', 'pengaduans.pengaduan_id')
            ->where('pengaduans.tiket', $tiket)
            ->first();

        $pengaduan = Pengaduan::where('tiket', $tiket)->firstOrFail();
        $jenisBarang = $pengaduan->jenis_barang; // Assuming jenis_barang is a column in the Pengaduan model
    
        // Get unique kode_barang values based on jenis_barang
        $kodeBarangOptions = Barang::where('nama', $jenisBarang)->pluck('kode_barang')->unique();
    
        // Get unique nup values based on kode_barang
        $nupOptions = Aset::where('kode_barang', $kodeBarangOptions)->pluck('nup')->unique();

        if (!$perbaikan) {
            return redirect()->back()->with('error', 'Perbaikan not found');
        }

        return view('roles.teknisi.update-daftar-perbaikan-teknisi', compact('userInfo','perbaikan','kodeBarangOptions', 'nupOptions'));
    }

}
