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
            'kode_ruang' => 'required',
            'prioritas' => 'required',
            'deskripsi' => 'required',
            'lampiran' => 'required|image|mimes:jpeg,png|max:2048', 
        ], [
            'jenis_barang.required'  => 'Jenis Barang wajib diisi!',
            'kode_ruang.required' => 'Ruang wajib diisi!',
            'kode_ruang.string' => 'Ruang harus berupa string!',
            'prioritas.required' => 'Kondisi wajib diisi!',
            'deskripsi.required' => 'Deskripsi wajib diisi!',
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
            'kode_ruang' => $request->input('kode_ruang'),
            'prioritas' => $request->input('prioritas'),
            'deskripsi' => $request->input('deskripsi'),
            'lampiran' => $lampiranPath, // Save the file path in the database
            'tiket' => $tiket,
        ]);

        // Anda juga dapat menambahkan pesan berhasil atau pesan error sesuai kebutuhan
        return redirect()->route('pelapor.daftar-pengaduan')->with('success', 'Pengaduan berhasil disimpan.');
    }

    public function data(Request $request)
    {
        $pengaduans = Pengaduan::with(['ruang']);
        // Filter data berdasarkan inputan user
        if ($request->filter_ruang != null) {
            $pengaduans->where('kode_ruang', $request->filter_ruang);
        }
        if ($request->filter_status != null) {
            $pengaduans->where('status', $request->filter_status);
        }
        if ($request->filter_prioritas != null) {
            $pengaduans->where('prioritas', $request->filter_prioritas);
            };

        // Handle sorting based on the request
        if ($request->has('order')) {
            $order = $request->order[0];
            $columnIndex = $order['column'];
            $columnName = $request->columns[$columnIndex]['name'];
            $sortDirection = $order['dir'];
            // $jadwalPemeliharaanAc->orderBy($columnName, $sortDirection);

            // Sorting untuk ruang
            if ($columnName == 'nama_ruang') {
                $columnName = "kode_ruang";

                // Use leftJoin with select to avoid duplicate column names
                $pengaduans->leftJoin('ruangs', 'pengaduans.kode_ruang', '=', 'ruangs.kode_ruang')
                    ->select('pengaduans.*', 'ruangs.nama as nama_ruang');

                // Use orderBy with the aliased column name
                $pengaduans->orderBy('nama_ruang', $sortDirection);
            } else {
                $pengaduans->orderBy($columnName, $sortDirection);
            }
        }

        return Datatables::of($pengaduans)
            ->addColumn('nama_ruang', function ($row) {
                return $row->ruang ? $row->ruang->nama : '-';
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
                return '<a href="/pelapor/daftar-pengaduan/detail/'.$pengaduans->tiket.'" class="btn btn-dark">Detail</a>';
            })
            ->rawColumns(['prioritas', 'status', 'action'])
            ->make(true);
    }

    public function dataKoordinator(Request $request)
    {
    
        $pengaduans = Pengaduan::select([
            'pengaduans.tiket',
            'pengaduans.tanggal',
            'pengaduans.jenis_barang',
            'ruangs.nama as nama_ruang', // Include 'nama_ruang' in the select statement
            'pengaduans.kode_ruang',
            'pengaduans.prioritas',
            'pengaduans.status',
            'users.name as teknisi_name',
        ])
        ->leftJoin('users', 'pengaduans.teknisi_id', '=', 'users.user_id')
        ->leftJoin('ruangs', 'pengaduans.kode_ruang', '=', 'ruangs.kode_ruang'); // Add a left join with the 'ruangs' table


        // Filter data berdasarkan inputan user
        if ($request->filter_ruang != null) {
            $pengaduans->where('pengaduans.kode_ruang', $request->filter_ruang);
        }
        if ($request->filter_status != null) {
            $pengaduans->where('status', $request->filter_status);
        }
        if ($request->filter_prioritas != null) {
            $pengaduans->where('prioritas', $request->filter_prioritas);
            };

        // Handle sorting based on the request
        if ($request->has('order')) {
            $order = $request->order[0];
            $columnIndex = $order['column'];
            $columnName = $request->columns[$columnIndex]['name'];
            $sortDirection = $order['dir'];

            // Sorting untuk ruang
            if ($columnName == 'nama_ruang') {
                // Use leftJoin with select to avoid duplicate column names
                $pengaduans->leftJoin('ruangs as ruang_sort', 'pengaduans.kode_ruang', '=', 'ruang_sort.kode_ruang')
                    ->leftJoin('users as teknisi', 'pengaduans.teknisi_id', '=', 'teknisi.user_id') // Use 'teknisi' as the alias for 'users'
                    ->select('pengaduans.*', 'ruang_sort.nama as nama_ruang', 'teknisi.name as teknisi_name');

                // Use orderBy with the aliased column name
                $pengaduans->orderBy('nama_ruang', $sortDirection);
            } else {
                $pengaduans->orderBy($columnName, $sortDirection);
            }
        }

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
                // Check if the status is "Menunggu" before rendering the button
                if ($pengaduans->status === 'Menunggu') {
                    return '<a href="/koordinator/daftar-pengaduan/detail/'.$pengaduans->tiket.'" class="btn btn-dark">Detail</a>';
                } else {
                    // If status is not "Menunggu," return a disabled button or other content
                    return '<button class="btn btn-dark" disabled>Detail</button>';
                    // You can customize the disabled button appearance or provide a different message
                }

                // return '<a href="/koordinator/daftar-pengaduan/detail/'.$pengaduans->tiket.'" class="btn btn-dark">Detail</a>';
            })            
            ->rawColumns(['prioritas', 'status', 'action'])
            ->make(true);
    }


    public function dataTeknisi(Request $request)
    {
        $pengaduans = Pengaduan::select([
            'pengaduans.tiket',
            'pengaduans.tanggal',
            'pengaduans.jenis_barang',
            'ruangs.nama as nama_ruang',
            'pengaduans.kode_ruang',
            'pengaduans.prioritas',
            'pengaduans.status',
            'users.name as teknisi_name',
        ])
        ->leftJoin('users', 'pengaduans.teknisi_id', '=', 'users.user_id')
        ->leftJoin('ruangs', 'pengaduans.kode_ruang', '=', 'ruangs.kode_ruang')
        ->where('pengaduans.teknisi_id', Auth::id());

        // Filter data berdasarkan inputan user
        if ($request->filter_ruang != null) {
            $pengaduans->where('ruangs.kode_ruang', $request->filter_ruang);
        }        
        if ($request->filter_status != null) {
            $pengaduans->where('status', $request->filter_status);
        }
        if ($request->filter_prioritas != null) {
            $pengaduans->where('prioritas', $request->filter_prioritas);
            };

        // Handle sorting based on the request
        if ($request->has('order')) {
            $order = $request->order[0];
            $columnIndex = $order['column'];
            $columnName = $request->columns[$columnIndex]['name'];
            $sortDirection = $order['dir'];

            // Sorting untuk ruang
            if ($columnName == 'nama_ruang') {
                // Use leftJoin with select to avoid duplicate column names
                $pengaduans->leftJoin('ruangs as ruang_sort', 'pengaduans.kode_ruang', '=', 'ruang_sort.kode_ruang')
                    ->leftJoin('users as teknisi', 'pengaduans.teknisi_id', '=', 'teknisi.user_id') // Use 'teknisi' as the alias for 'users'
                    ->where('pengaduans.teknisi_id', Auth::id())
                    ->select('pengaduans.*', 'ruang_sort.nama as nama_ruang', 'teknisi.name as teknisi_name');

                // Use orderBy with the aliased column name
                $pengaduans->orderBy('nama_ruang', $sortDirection);
            } else {
                $pengaduans->orderBy($columnName, $sortDirection);
            }
        }

        return Datatables::of($pengaduans)
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
                return '<a href="/teknisi/daftar-pengaduan/detail/'.$pengaduans->tiket.'" class="btn btn-dark">Detail</a>';
            })            
            ->rawColumns(['prioritas', 'status', 'action'])
            ->make(true);
    }

}