<?php

namespace App\Http\Controllers;

use App\Models\PengecekanKelas;
use Carbon\Carbon;
use App\Models\Pengaduan;
use App\Models\Perbaikan;
use App\Models\User;
use App\Models\Ruang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


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
        $adminUsers = User::where('role', 'Admin')->get();
        return view('roles.koordinator.penugasan-admin', compact('userInfo', 'adminUsers', 'pengecekanKelas'));
    }

    public function daftarPengaduan() {
        // Assuming you have a method to retrieve the list of pengaduans
        //$pengaduans = Pengaduan::all(); // Adjust the logic based on your implementation
    
        $userInfo = $this->getUserInfo();
    
        // Pass the userInfo and pengaduans variables to the view
        return view('roles.koordinator.daftar-pengaduan-koordinator', compact('userInfo'));
    }

    public function daftarPengaduanDetail($tiket)
    {
        $userInfo = $this->getUserInfo();
        $pengaduans = DB::table('pengaduans')->where('tiket', $tiket)->first();
        // Convert the date string to a Carbon instance
        $pengaduans->tanggal = Carbon::parse($pengaduans->tanggal);
        $teknisis = User::where('role', 'teknisi')->get();
        return view('roles.koordinator.daftar-pengaduan-detail-koordinator', compact('userInfo', 'pengaduans', 'teknisis'));
    }

    public function updatePengaduan(Request $request, $tiket)
    {
        // Validate the request
        $request->validate([
            'teknisi_id' => 'nullable|exists:users,user_id,role,teknisi', // Assuming you have a "users" table
        ]);

        // Update the pengaduan based on the request data
        DB::table('pengaduans')
            ->where('tiket', $tiket)
            ->update([
                'status' => "Dikerjakan",
                'teknisi_id' => $request->input('teknisi_id'),
            ]);

        // Redirect back to the list of pengaduans with a success message
        return redirect()->route('koordinator.daftar-pengaduan')->with('success', 'Pengaduan berhasil diupdate.');
    }


    public function tolakPengaduan(Request $request, $tiket)
    {
        // Validate the request
        $request->validate([
            'alasan_ditolak' => 'required',
        ]);

        // Update the pengaduan based on the request data
        DB::table('pengaduans')
            ->where('tiket', $tiket)
            ->update([
                'status' => 'Ditolak',
                'alasan_ditolak' => $request->input('alasan_ditolak'),
            ]);

        // Redirect back to the list of pengaduans with a success message
        return redirect()->route('koordinator.daftar-pengaduan')->with('success', 'Pengaduan berhasil ditolak.');
    }

    public function daftarPerbaikan()
    {
        $userInfo = $this->getUserInfo();
        $perbaikans = Perbaikan::join('pengaduans', 'perbaikans.pengaduan_id', '=', 'pengaduans.pengaduan_id')
            ->select('perbaikans.*', 'pengaduans.tiket', 'pengaduans.tanggal', 'pengaduans.jenis_barang', 'pengaduans.teknisi_id', 'pengaduans.kode_ruang')
            ->get();
        return view('roles.koordinator.daftar-perbaikan-koordinator', compact('userInfo', 'perbaikans'));
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

        return view('roles.koordinator.daftar-perbaikan-detail-koordinator', compact('userInfo','perbaikan'));
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
