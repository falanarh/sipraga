<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Aset;
use Illuminate\Http\Request;
use App\Models\JadwalPemeliharaanAc;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class JadwalPemeliharaanAcController extends Controller
{
    //Generate jadwal pemeliharaan AC
    public function generateJadwal()
    {
        // Ambil semua aset AC yang memiliki tanggal pemeliharaan terakhir
        $asets = Aset::whereNotNull('tanggal_pemeliharaan_terakhir')->get();

        foreach ($asets as $aset) {
            // Ambil jadwal terakhir AC dengan status "Sudah Dikerjakan"
            $jadwalSebelumnya = JadwalPemeliharaanAc::where('kode_barang', $aset->kode_barang)
                ->where('nup', $aset->nup)
                ->latest()
                ->first();
            // ->where('status', 'Selesai Dikerjakan')

            // Jika jadwal sebelumnya tidak ditemukan, buat jadwal baru awal
            if (!$jadwalSebelumnya) {
                //Hitung selisih bulan
                $selisihBulan = Carbon::parse($aset->tanggal_pemeliharaan_terakhir)->diffInMonths(now());

                // Hitung jumlah bulan yang harus ditambahkan agar mendapatkan tanggal waktu mendatang
                $bulanTambah = ceil(($selisihBulan + 1) / 6) * 6;

                JadwalPemeliharaanAc::create([
                    'nomor' => JadwalPemeliharaanAc::count() + 1,
                    'kode_barang' => $aset->kode_barang,
                    'nup' => $aset->nup,
                    'kode_ruang' => $aset->kode_ruang,
                    'tanggal_pelaksanaan' => $aset->tanggal_pemeliharaan_terakhir->addMonths($bulanTambah),
                ]);
            } else {

                if ($jadwalSebelumnya->status == "Selesai Dikerjakan") {
                    JadwalPemeliharaanAc::create([
                        'nomor' => JadwalPemeliharaanAc::count() + 1,
                        'kode_barang' => $aset->kode_barang,
                        'nup' => $aset->nup,
                        'kode_ruang' => $aset->kode_ruang,
                        'tanggal_pelaksanaan' => $jadwalSebelumnya->tanggal_pelaksanaan->addMonths(6),
                    ]);
                }
            }
        }

        return redirect()->route('teknisi.jadwal')->with('success', 'Jadwal pemeliharaan AC berhasil digenerate!');
    }

    public function setTeknisiId($jadwalPemeliharaanAcId, $teknisiId)
    {
        $jadwalPemeliharaanAc = JadwalPemeliharaanAc::find($jadwalPemeliharaanAcId);
        $jadwalPemeliharaanAc->teknisi_id = $teknisiId;
        $jadwalPemeliharaanAc->status = "Sedang Dikerjakan";

        $jadwalPemeliharaanAc->save();

        return redirect()->route('teknisi.jadwal')->with('success', 'Teknisi berhasil ditambahkan!');
    }

    public function data(Request $request)
    {
        $jadwalPemeliharaanAc = JadwalPemeliharaanAc::with(['ruang', 'user']);
        
        $jadwalPemeliharaanAc->orderBy('tanggal_pelaksanaan', 'desc')
        ->orderByRaw("FIELD(status, 'Belum Dikerjakan', 'Sedang Dikerjakan', 'Selesai Dikerjakan')");

        // Filter data berdasarkan inputan user
        if ($request->filter_ruang != null) {
            $jadwalPemeliharaanAc->where('kode_ruang', $request->filter_ruang);
        }
        if ($request->filter_status != null) {
            $jadwalPemeliharaanAc->where('status', $request->filter_status);
        }
        if ($request->filter_teknisi != null) {
            $jadwalPemeliharaanAc->whereHas('user', function ($query) use ($request) {
                $query->where('name', $request->filter_teknisi);
            });
        }

        // Handle sorting based on the request
        if ($request->has('order')) {
            $order = $request->order[0];
            $columnIndex = $order['column'];
            $columnName = $request->columns[$columnIndex]['name'];
            $sortDirection = $order['dir'];
            //$jadwalPemeliharaanAc->orderBy($columnName, $sortDirection);

            // Sorting untuk teknisi dan ruang
            if ($columnName == 'teknisi') {
                $columnName = $columnName . "_id";

                // Use leftJoin with select to avoid duplicate column names
                $jadwalPemeliharaanAc->leftJoin('users', $columnName, '=', 'users.user_id')
                    ->select('jadwal_pemeliharaan_acs.*', 'users.name as teknisi_name');

                // Use orderBy with the aliased column name
                $jadwalPemeliharaanAc->orderBy('teknisi_name', $sortDirection);
            } else if ($columnName == 'ruang') {
                $columnName = "kode_" . $columnName;

                // Use leftJoin with select to avoid duplicate column names
                $jadwalPemeliharaanAc->leftJoin('ruangs', 'jadwal_pemeliharaan_acs.' . $columnName, '=', 'ruangs.kode_ruang')
                    ->select('jadwal_pemeliharaan_acs.*', 'ruangs.nama as nama_ruang');

                // Use orderBy with the aliased column name
                $jadwalPemeliharaanAc->orderBy('nama_ruang', $sortDirection);
            } else {
                $jadwalPemeliharaanAc->orderBy($columnName, $sortDirection);
            }
        }

        return DataTables::of($jadwalPemeliharaanAc)
            ->addColumn('tanggal_pelaksanaan', function ($row) {
                return $row->tanggal_pelaksanaan->format('d/m/Y');
            })
            ->addColumn('kode_barang', function ($row) {
                return $row->kode_barang;
            })
            ->addColumn('nup', function ($row) {
                return $row->nup;
            })
            ->addColumn('ruang', function ($row) {
                return $row->ruang->nama;
            })
            ->addColumn('teknisi', function ($row) {
                if ($row->user == null)
                    return "N/A";
                else
                    return $row->user->name;
            })
            ->addColumn('status', function ($row) {
                $statusClass = ''; // Default class
                $statusText = $row->status; // Default status text

                switch ($row->status) {
                    case 'Belum Dikerjakan':
                        $statusClass = 'bg-rounded-status-monitoring rounded-pill bg-warning';
                        break;
                    case 'Sedang Dikerjakan':
                        $statusClass = 'bg-rounded-status-monitoring rounded-pill bg-primary';
                        break;
                    case 'Selesai Dikerjakan':
                        $statusClass = 'bg-rounded-status-monitoring rounded-pill bg-success';
                        break;

                    default:
                        // Handle other cases or leave as is
                }
                return '<div class="' . $statusClass . '">' . $statusText . '</div>';
            })

            ->addColumn('action', function ($row) {
                // Ambil ID teknisi yang sedang login dan tampilkan namanya di kolom "Teknisi"
                $idTeknisiLogin = auth()->user()->user_id;

                if ($row->status == "Selesai Dikerjakan") {
                    return '
                                <a class="btn btn-outline-secondary disabled">Ubah</a>
                                <a class="btn btn-outline-success disabled ms-2">Catat</a>
                            ';
                }
                if ($row->status == "Sedang Dikerjakan") {

                    if($row->user->user_id == $idTeknisiLogin) {
                        return '
                                <a class="btn btn-outline-secondary disabled">Ubah</a>
                                <a href="/teknisi/jadwal-pemeliharaan/pemeliharaan/' . $row->jadwal_pemeliharaan_ac_id . '/edit" class="btn btn-success ms-2">Catat</a>
                            ';
                    } else {
                        return '
                                <a class="btn btn-outline-secondary disabled">Ubah</a>
                                <a class="btn btn-outline-success disabled ms-2">Catat</a>
                            ';
                    }
                } else {
                    
                    return '<a href="' . route('teknisi.jadwal.set', ['jadwal_pemeliharaan_ac_id' => $row->jadwal_pemeliharaan_ac_id, 'teknisi_id' => $idTeknisiLogin]) . '" class="btn btn-secondary" id="ubah">Ubah</a>' .
                        '<a class="btn btn-outline-success disabled ms-2">Catat</a>';
                }
            })
            ->filterColumn('tanggal', function ($query, $keyword) {
                $query->whereDate('tanggal_pelaksanaan', 'like', '%' . $keyword . '%');
            })
            ->filterColumn('kode_barang', function ($query, $keyword) {
                $query->where('kode_barang', 'like', '%' . $keyword . '%');
            })
            ->filterColumn('nup', function ($query, $keyword) {
                $query->where('nup', 'like', '%' . $keyword . '%');
            })
            ->filterColumn('ruang', function ($query, $keyword) {
                $query->whereHas('ruang', function ($query) use ($keyword) {
                    $query->where('nama', 'like', '%' . $keyword . '%');
                });
            })
            ->filterColumn('status', function ($query, $keyword) {
                $query->where('status', 'like', '%' . $keyword . '%');
            })
            ->filterColumn('teknisi', function ($query, $keyword) {
                $query->whereHas('user', function ($query) use ($keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%');
                });
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }
}
