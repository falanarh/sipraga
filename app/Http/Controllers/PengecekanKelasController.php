<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\PengecekanKelas;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PengecekanKelasController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'tanggal' => 'required|date',
        ], [
            'tanggal.required' => 'Tanggal wajib diisi!',
            'tanggal.date' => 'Format tanggal tidak valid.',
        ]);

        // Menghitung jumlah baris data yang sudah ada
        $jumlahBarisData = PengecekanKelas::count();

        // Menambahkan kolom nomor
        $request->merge(['nomor' => $jumlahBarisData + 1]);

        // Menyimpan data baru ke dalam tabel
        PengecekanKelas::create($request->all());

        // Redirect dengan pesan sukses
        return redirect()
            ->route('koordinator.jadwal-pengecekan-kelas') // Ganti dengan nama route yang sesuai
            ->with('success', 'Jadwal pengecekan kelas berhasil ditambahkan!');
    }

    public function generate(Request $request)
    {
        // Ambil data tanggal pelaksanaan terakhir dari ruangan tertentu
        $lastCheck = PengecekanKelas::where('kode_ruang', $request->input('kode_ruang'))
            ->latest('tanggal') // Ambil data terbaru berdasarkan tanggal
            ->first();

        if ($lastCheck && $lastCheck->status == 'Sudah Dikerjakan') {
            // Jika status jadwal terakhir adalah "Sudah Dikerjakan", generate jadwal baru

            // Tambahkan 1 bulan ke tanggal pelaksanaan terakhir
            $newCheckDate = Carbon::parse($lastCheck->tanggal)->addMonth();

            // Menambahkan kolom nomor
            $request->merge(['nomor' => PengecekanKelas::count() + 1]);

            // Menyimpan data baru ke dalam tabel
            PengecekanKelas::create([
                'nomor' => $request->input('nomor'),
                'tanggal' => $newCheckDate,
                'kode_ruang' => $request->input('kode_ruang'),
                // tambahkan atribut-atribut lain yang diperlukan
            ]);

            // Redirect dengan pesan sukses
            return redirect()
                ->route('koordinator.jadwal-pengecekan-kelas') // Ganti dengan nama route yang sesuai
                ->with('success', 'Jadwal pengecekan kelas berhasil ditambahkan!');
        } else {
            // Jika status jadwal terakhir bukan "Sudah Dikerjakan", tampilkan pesan kesalahan
            return redirect()
                ->route('koordinator.jadwal-pengecekan-kelas') // Ganti dengan nama route yang sesuai
                ->with('error', 'Tidak dapat menambahkan jadwal baru. Status jadwal sebelumnya belum selesai!');
        }
    }

    public function tugaskanAdmin(Request $request, $pengecekan_kelas_id)
    {
        $pengecekanKelas = PengecekanKelas::find($pengecekan_kelas_id);

        $pengecekanKelas->admin_id = $request->admin_id;
        $pengecekanKelas->save();

        return redirect()
            ->route('koordinator.jadwal-pengecekan-kelas') // Ganti dengan nama route yang sesuai
            ->with('success', 'Berhasil menugaskan admin untuk jadwal pengecekan kelas!');
    }

    public function selesaikan($pengecekan_kelas_id)
    {
        $pengecekanKelas = PengecekanKelas::find($pengecekan_kelas_id);

        $pengecekanKelas->status = "Sudah Dikerjakan";
        $pengecekanKelas->save();

        return redirect()
            ->route('admin.jadwal-pengecekan-kelas') // Ganti dengan nama route yang sesuai
            ->with('success', 'Berhasil menyelesaikan jadwal pengecekan kelas!');
    }

    public function dataKoordinator()
    {
        $pengecekanKelas = PengecekanKelas::with(['ruang', 'user'])->get();

        return Datatables::of($pengecekanKelas)
            ->addColumn('tanggal', function ($pengecekanKelas) {
                // Format tanggal sesuai kebutuhan Anda
                return $pengecekanKelas->tanggal->format('d-m-Y');
            })
            ->addColumn('nama_ruang', function ($pengecekanKelas) {
                return $pengecekanKelas->ruang->nama;
            })
            ->addColumn('admin', function ($pengecekanKelas) {
                if ($pengecekanKelas->user == null) {
                    return "-";
                } else {
                    return $pengecekanKelas->user->name;
                }
            })
            ->addColumn('action', function ($pengecekanKelas) {
                if ($pengecekanKelas->admin_id != null || $pengecekanKelas->status == "Sudah Dikerjakan") {
                    return '<a class="btn btn-outline-dark disabled">Tugaskan</a>';
                } else {
                    return '<a href="' . route("koordinator.jadwal-pengecekan-kelas.penugasan-form", ['pengecekan_kelas_id' => $pengecekanKelas->pengecekan_kelas_id]) . '" class="btn btn-dark tugaskanButton">Tugaskan</a>';
                }
            })
            ->make(true);
    }

    public function dataAdmin()
    {
        // Mendapatkan ID user yang sedang login
        $loggedInUserId = Auth::id();

        $pengecekanKelas = PengecekanKelas::with(['ruang', 'user'])
        ->where('admin_id', $loggedInUserId) // Menyaring berdasarkan admin_id yang sesuai
        ->orderBy('status', 'asc') // Urutkan berdasarkan status (Belum Dikerjakan akan lebih dulu)
        ->orderBy('tanggal', 'desc') // Jika status sama, urutkan berdasarkan tanggal paling dekat
        ->get();

        return Datatables::of($pengecekanKelas)
            ->addColumn('tanggal', function ($pengecekanKelas) {
                // Format tanggal sesuai kebutuhan Anda
                return $pengecekanKelas->tanggal->format('d-m-Y');
            })
            ->addColumn('nama_ruang', function ($pengecekanKelas) {
                return $pengecekanKelas->ruang->nama;
            })
            ->addColumn('action', function ($pengecekanKelas) {
                if ( $pengecekanKelas->status == "Sudah Dikerjakan") {
                    return '<a class="btn btn-outline-dark disabled">Ubah</a>';
                } else {
                    $url = route("admin.jadwal-pengecekan-kelas.selesaikan", [
                        'pengecekan_kelas_id' => $pengecekanKelas->pengecekan_kelas_id,
                    ]);
    
                    return '<a href="' . $url . '" class="btn btn-dark tugaskanButton">Ubah</a>';
                }
            })
            ->make(true);
    }

    // public function data()
    // {
    //     $ruang = Ruang::select(['nomor', 'kode_ruang', 'nama', 'gedung', 'lantai', 'kapasitas']);

    //     return Datatables::of($ruang)
    //         ->addColumn('action', function ($ruang) {
    //             return '<a href="/admin/data-ruangan/' . $ruang->kode_ruang . '/edit" class="btn-act text-dark me-1">
    //                          <img src="' . asset('images/icons/edit.svg') . '" alt="">
    //                      </a>
    //                      <a href="/admin/data-ruangan/' . $ruang->kode_ruang . '/hapus" class="btn-act text-dark me-1" id="hapus-ruang">
    //                          <img src="' . asset('images/icons/trash.svg') . '" alt="">
    //                      </a>';
    //         })
    //         ->make(true);
    // }
}
