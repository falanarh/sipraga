<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aset;
use App\Models\JadwalPemeliharaanAc;
use Carbon\Carbon;
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

    public function data()
    {
        $jadwalPemeliharaanAc = JadwalPemeliharaanAc::with(['ruang', 'user']);
        
        return DataTables::of($jadwalPemeliharaanAc)
            -> addColumn('tanggal', function($row){
                return $row->tanggal_pelaksanaan->format('d/m/Y');
            })
            -> addColumn('kode_barang', function($row){
                return $row->kode_barang;
            })
            -> addColumn('nup', function($row){
                return $row->nup;
            })
            -> addColumn('ruang', function($row){
                return $row->ruang->nama;
            })
            -> addColumn('teknisi', function($row){
                if($row->user == null)
                    return "-";
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
                if ( $row->status == "Selesai Dikerjakan") {
                    return '
                                <a class="btn btn-outline-secondary disabled">Ubah</a>
                                <a class="btn btn-outline-success disabled">Catat</a>
                            ';
                } if($row->status == "Sedang Dikerjakan"){
                    return '
                                <a class="btn btn-outline-secondary disabled">Ubah</a>
                                <a href="/teknisi/jadwal-pemeliharaan/pemeliharaan/'. $row->jadwal_pemeliharaan_ac_id.'/edit" class="btn btn-success">Catat</a>
                            ';
                }
                else {
                    // Ambil ID teknisi yang sedang login dan tampilkan namanya di kolom "Teknisi"
                    $idTeknisiLogin = auth()->user()->user_id; 
                    return '<a href="' . route('teknisi.jadwal.set', ['jadwal_pemeliharaan_ac_id' => $row->jadwal_pemeliharaan_ac_id, 'teknisi_id' => $idTeknisiLogin]) . '" class="btn btn-secondary" id="ubah">Ubah</a>' .
                            '<a class="btn btn-outline-success disabled">Catat</a>';

                }
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }
}
