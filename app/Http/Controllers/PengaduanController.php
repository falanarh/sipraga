<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Pengaduan;
use Barryvdh\DomPDF\PDF;
use App\Rules\NotTomorrow;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Barang;
use App\Models\Ruang;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PengaduanController extends Controller
{
    public function store(Request $request)
    {
        // Validasi data yang diterima dari formulir, termasuk validasi untuk file upload
        $request->validate([
            'jenis_barang' => 'required|string',
            // 'kode_barang' => 'required|string',
            // 'nup' => 'required|string',
            'kode_ruang' => 'required',
            'prioritas' => 'required',
            'deskripsi' => 'required',
            // 'keterangan' => 'required',
            // 'alasan_ditolak' => 'required',
            // 'teknisi_id' => 'required',
            'lampiran' => 'required|image|mimes:jpeg,png|max:2048', 
        ], [
            'jenis_barang.required'  => 'Jenis Barang wajib diisi!',
            // 'kode_barang.required'  => 'Kode Barang wajib diisi!',
            // 'nup.required'  => 'NUP wajib diisi!',
            // 'teknisi_id.required'  => 'Teknisi wajib diisi!',
            'kode_ruang.required' => 'Ruang wajib diisi!',
            'kode_ruang.string' => 'Ruang harus berupa string!',
            'prioritas.required' => 'Kondisi wajib diisi!',
            'deskripsi.required' => 'Deskripsi wajib diisi!',
            // 'keterangan.required' => 'Mohon isikan keterangan perbaikan',
            // 'alasan_ditolak.required' => 'Mohon sertakan alasan penolakan pengaduan',
            'lampiran.required' => 'Lampiran wajib diisi!',
        ]);

        // Get the authenticated user
        $user = Auth::user();

        // Generate a random 6-character ticket
        $tiket = Str::random(6);

        // Store the uploaded file with a custom name
        $lampiranName = $tiket . '.' . $request->file('lampiran')->getClientOriginalExtension();
        $lampiranPath = $request->file('lampiran')->storeAs('lampiran', $lampiranName, 'public');

        // Proses penyimpanan data ke dalam database
        // You can use Eloquent model to store data in the appropriate table
        Pengaduan::create([
            'pelapor_id' => $user->user_id,
            'tanggal' => Carbon::now(),
            'jenis_barang' => $request->input('jenis_barang'),
            // 'kode_barang' => $request->input('kode_barang'),
            // 'nup' => $request->input('nup'),
            'kode_ruang' => $request->input('kode_ruang'),
            'prioritas' => $request->input('prioritas'),
            'deskripsi' => $request->input('deskripsi'),
            // 'status' => $request->input('status'),
            // 'teknisi_id' => $request->input('teknisi_id'),
            // 'keterangan' => $request->input('keterangan'),
            // 'alasan_ditolak' => $request->input('alasan_ditolak'),
            'lampiran' => $lampiranPath, // Save the file path in the database
            'tiket' => $tiket,
            // Add other fields as needed
        ]);

        // Anda juga dapat menambahkan pesan berhasil atau pesan error sesuai kebutuhan
        return redirect()->route('pelapor.daftar-pengaduan')->with('success', 'Pengaduan berhasil disimpan.');
    }

    // public function konfirmasiPengaduan(Request $request, $tiket)
    // {
    //     // Validate the request
    //     $request->validate([
    //         'status' => 'required|in:Dikerjakan,Ditolak',
    //         'alasan_ditolak' => 'required_if:status,Ditolak',
    //         'teknisi_id' => 'nullable|exists:teknisis,id', // Assuming you have a "teknisis" table
    //     ]);

    //     // Find the pengaduan by tiket
    //     $pengaduan = Pengaduan::where('tiket', $tiket)->firstOrFail();

    //     // Update the pengaduan based on the request data
    //     $pengaduan->update([
    //         'status' => $request->input('status'),
    //         'alasan_ditolak' => $request->input('alasan_ditolak'),
    //         'teknisi_id' => $request->input('teknisi_id'),
    //     ]);

    //     // Redirect back to the list of pengaduans with a success message
    //     return redirect()->route('koordinator.daftar-pengaduan')->with('success', 'Pengaduan berhasil dikonfirmasi.');
    // }

    public function data()
{
    $pengaduans = Pengaduan::select(['pengaduans.tiket', 'pengaduans.tanggal', 'pengaduans.jenis_barang', 'ruangs.nama as nama_ruang', 'pengaduans.prioritas', 'pengaduans.status'])
        ->leftJoin('ruangs', 'pengaduans.kode_ruang', '=', 'ruangs.kode_ruang');

    return Datatables::of($pengaduans)
        ->addColumn('action', function ($pengaduans) {
            return '<a href="/pelapor/daftar-pengaduan/detail/' . $pengaduans->tiket . '" class="btn btn-dark">Detail</a>';
        })
        ->make(true);
}

    public function dataKoordinator()
{
    $pengaduans = Pengaduan::select([
        'pengaduans.tiket',
        'pengaduans.tanggal',
        'pengaduans.jenis_barang',
        'pengaduans.kode_ruang',
        'pengaduans.prioritas',
        'pengaduans.status',
        'users.name as teknisi_name',
    ])
    ->leftJoin('users', 'pengaduans.teknisi_id', '=', 'users.user_id')
    ->orderBy('pengaduans.tanggal', 'desc');

    return Datatables::of($pengaduans)
        ->addColumn('teknisi_name', function($pengaduans) {
            return $pengaduans->teknisi_name ?: 'N/A';
        })
        ->addColumn('prioritas', function($pengaduans) {
            $prioritasClass = ''; // Default class
            $prioritasText = $pengaduans->prioritas; // Default prioritas text

            switch ($pengaduans->prioritas) {
                case 'Sedang':
                    $prioritasClass = 'bg-rounded-prior rounded-pill bg-warning';
                    break;
                case 'Rendah':
                    $prioritasClass = 'bg-rounded-prior rounded-pill bg-primary';
                    break;
                case 'Tinggi':
                    $prioritasClass = 'bg-rounded-prior rounded-pill bg-danger';
                    break;

                default:
                    // Handle other cases or leave as is
            }
            return '<div class="' . $prioritasClass . '">' . $prioritasText . '</div>';
        })
        ->addColumn('status', function($pengaduans) {
            $statusClass = ''; // Default class
            $statusText = $pengaduans->status; // Default status text

            switch ($pengaduans->status) {
                case 'Menunggu':
                    $statusClass = 'bg-rounded-status rounded-pill bg-warning';
                    break;
                case 'Dikerjakan':
                    $statusClass = 'bg-rounded-status rounded-pill bg-primary';
                    break;
                case 'Selesai':
                    $statusClass = 'bg-rounded-status rounded-pill bg-success';
                    break;
                case 'Ditolak':
                    $statusClass = 'bg-rounded-status rounded-pill bg-danger';
                    break;

                default:
                    // Handle other cases or leave as is
            }
            return '<div class="' . $statusClass . '">' . $statusText . '</div>';
        })
        ->addColumn('action', function($pengaduans) {
            return '<a href="/koordinator/daftar-pengaduan/detail/'.$pengaduans->tiket.'" class="btn btn-dark">Detail</a>';
        })
        ->rawColumns(['prioritas', 'status', 'action'])
        ->make(true);
}


public function dataTeknisi()
{
    $pengaduans = Pengaduan::select([
        'pengaduans.tiket',
        'pengaduans.tanggal',
        'pengaduans.jenis_barang',
        'pengaduans.kode_ruang',
        'pengaduans.prioritas',
        'pengaduans.status',
        'users.name as teknisi_name',
    ])
    ->leftJoin('users', 'pengaduans.teknisi_id', '=', 'users.user_id')
    ->where('pengaduans.teknisi_id', Auth::id())
    ->orderBy('pengaduans.tanggal', 'desc');

    return Datatables::of($pengaduans)
        // ->addColumn('teknisi_name', function($pengaduans) {
        //     return $pengaduans->teknisi_name ?: 'N/A';
        // })
        ->addColumn('action', function($pengaduans) {
            return '<a href="/teknisi/daftar-pengaduan/detail/'.$pengaduans->tiket.'" class="btn btn-dark">Detail</a>';
        })
        ->make(true);
}



}