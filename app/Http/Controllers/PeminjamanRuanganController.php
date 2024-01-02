<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Ruang;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\PeminjamanRuangan;
use Illuminate\Routing\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StorePeminjamanRuanganRequest;
use App\Http\Requests\UpdatePeminjamanRuanganRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class PeminjamanRuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePeminjamanRuanganRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'kode_ruang' => ['required', 'string'],
                'peminjam' => ['required', 'string'],
                'keterangan' => ['required', 'string'],
                'status' => ['required', 'string'],
                'tanggapan' => ['nullable', 'string'],
                // 'waktu' => ['required', 'date_format:d/m/Y H:i'],
            ], [
                'kode_ruang.required' => 'Ruang wajib diisi!',
                'kode_ruang.string' => 'Ruang harus berupa string!',
                'peminjam.required' => 'Peminjam wajib diisi!',
                'peminjam.string' => 'Peminjam harus berupa string!',
                'keterangan.required' => 'Keterangan wajib diisi!',
                'keterangan.string' => 'Keterangan harus berupa string!',
                'status.required' => 'Status wajib diisi!',
                'status.string' => 'Status harus berupa string!',
                'tanggapan.string' => 'Tanggapan harus berupa string!',
                'waktu.required' => 'Waktu wajib diisi!',
                'waktu.date_format' => 'Format waktu tidak valid. Gunakan format dd/mm/yyyy H:i.',
            ]);

            // Menghitung jumlah baris data yang sudah ada
            $jumlahBarisData = PeminjamanRuangan::count();

            // Menambahkan kolom nomor
            $request->merge(['nomor' => $jumlahBarisData + 1]);
            $request->merge(['nomor' => $jumlahBarisData + 1]);

            // Menyimpan data baru ke dalam tabel
            PeminjamanRuangan::create($request->all());

            $response = [
                'success' => 'Peminjaman ruangan berhasil dibuat!'
            ];

            return response()->json($response, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            $response = [
                'error' => 'Terjadi kesalahan saat menyimpan data peminjaman ruangan.',
                'details' => $e->getMessage(),
            ];

            return response()->json($response, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function data(Request $request)
    {
        $peminjamanRuangans = PeminjamanRuangan::with(['ruang']);

        $peminjamanRuangans->orderBy('tgl_mulai', 'desc')->orderByRaw("FIELD(status, 'Ditolak', 'Dialihkan', 'Diterima')");

        return Datatables::of($peminjamanRuangans)
            ->addColumn('tanggal_peminjaman', function ($row) {
                if ($row->tgl_mulai == $row->tgl_selesai) {
                    return $row->tgl_mulai->format('d/m/Y');
                } else {
                    return $row->tgl_mulai->format('d/m/Y') . '-' . $row->tgl_selesai->format('d/m/Y');
                }
            })
            ->addColumn('waktu', function ($row) {
                return date('H:i', strtotime($row->waktu_mulai)) . '-' . date('H:i', strtotime($row->waktu_selesai));
            })
            ->addColumn('nama_ruang', function ($row) {
                return $row->ruang->nama;
            })
            ->addColumn('status', function ($row) {
                $statusClass = ''; // Default class
                $statusText = $row->status; // Default status text

                switch ($row->status) {
                    case 'Diterima':
                        $statusClass = 'bg-rounded-status-monitoring rounded-pill bg-success';
                        break;
                    case 'Dialihkan':
                        $statusClass = 'bg-rounded-status-monitoring rounded-pill bg-warning';
                        break;
                    case 'Ditolak':
                        $statusClass = 'bg-rounded-status-monitoring rounded-pill bg-danger';
                        break;

                    default:
                        // Handle other cases or leave as is
                }
                return '<div class="' . $statusClass . '">' . $statusText . '</div>';
            })
            ->addColumn('action', function ($row) {
                // Menggunakan fungsi route dengan menyertakan peminjaman_ruangan_id
                return '<a href="' . route('admin.pengelolaan-peminjaman.detail', ['peminjaman_ruangan_id' => $row->peminjaman_ruangan_id]) . '" class="btn btn-dark">Detail</a>';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function getPeminjamanRuangUser(Request $request)
    {
        try {
            $peminjam = $request->query('namaUser');
            $dataPeminjaman = PeminjamanRuangan::join('ruangs', 'peminjaman_ruangans.kode_ruang', '=', 'ruangs.kode_ruang')
                ->where('peminjam', $peminjam)
                ->orderBy('tgl_mulai', 'asc') // Urutkan secara ascending berdasarkan tgl_mulai
                ->orderByRaw("FIELD(status, 'Ditolak', 'Dialihkan', 'Diterima')")
                ->get([
                    'peminjaman_ruangans.peminjam',
                    'peminjaman_ruangans.keterangan',
                    'peminjaman_ruangans.status',
                    'ruangs.kode_ruang',
                    'ruangs.nama as nama_ruang'
                ]);

            // Cek apakah peminjam ditemukan
            if ($dataPeminjaman->isEmpty()) {
                throw new ModelNotFoundException("Data peminjaman ruangan tidak ditemukan untuk peminjam: $peminjam");
            }

            $response = [
                'status_code' => 200,
                'message' => 'Berhasil mendapatkan data peminjaman ruangan dari ' . $peminjam . '!',
                'data' => $dataPeminjaman,
            ];

            return response()->json($response, 200);
        } catch (ModelNotFoundException $e) {
            $response = [
                'status_code' => 404,
                'error' => $e->getMessage(),
            ];

            return response()->json($response, 404);
        } catch (Exception $e) {
            $response = [
                'status_code' => 500,
                'error' => $e->getMessage(),
            ];

            return response()->json($response, 500);
        }
    }

    public function tolakPeminjamanRuangan(Request $request)
    {
        try {
            $peminjaman_ruangan_id = $request->peminjaman_ruangan_id;
            $tanggapan = $request->tanggapanBaru2;

            // Ambil peminjaman ruangan berdasarkan ID
            $peminjaman_ruangan = PeminjamanRuangan::where('peminjaman_ruangan_id', $peminjaman_ruangan_id)->firstOrFail();

            // Lakukan update atribut yang diinginkan
            $peminjaman_ruangan->status = "Ditolak";
            $peminjaman_ruangan->tanggapan = $tanggapan;
            $peminjaman_ruangan->save();

            // Berikan respons sukses
            return redirect()->route('admin.pengelolaan-peminjaman.detail', ['peminjaman_ruangan_id' => $peminjaman_ruangan->peminjaman_ruangan_id])->with('success', 'Peminjaman ruangan telah ditolak!');
        } catch (ModelNotFoundException $e) {
            // Handle jika peminjaman ruangan tidak ditemukan
            return redirect()->route('admin.pengelolaan-peminjaman.detail', ['peminjaman_ruangan_id' => $peminjaman_ruangan->peminjaman_ruangan_id])->with('error', 'Peminjaman ruangan tidak ditemukan.');
        } catch (Exception $e) {
            // Handle exception lainnya
            return redirect()->route('admin.pengelolaan-peminjaman.detail', ['peminjaman_ruangan_id' => $peminjaman_ruangan->peminjaman_ruangan_id])->with('error', $e->getMessage());
        }
    }
}
