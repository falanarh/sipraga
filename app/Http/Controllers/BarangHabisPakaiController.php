<?php

namespace App\Http\Controllers;

use DateTime;
use Dompdf\Dompdf;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\BarangHabisPakai;
use App\Http\Controllers\Controller;
use App\Models\AmbilBarangHabisPakai;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB; // Pastikan sudah diimport

class BarangHabisPakaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenis_barang' => 'required',
            'jumlah' => 'required|integer|max:2147483647|gt:0',
        ], [
            'jenis_barang.required' => 'jenis barang wajib diisi!',
            'jumlah.required' => 'jumlah wajib diisi!',
            'jumlah.integer' => 'jumlah harus berupa angka!',
            'jumlah.max' => 'jumlah tidak boleh lebih dari 9 digit!',
            'jumlah.gt' => 'jumlah barang yang diisikan harus lebih dari 0',
        ]);

        $jumlahBarisData = BarangHabisPakai::count();

        $jenis_barang_bhp = BarangHabisPakai::where('jenis_barang', $request->jenis_barang)->first();
        $bhp_id = $jenis_barang_bhp->bhp_id;
        $satuan = $jenis_barang_bhp->satuan;

        $request->merge([
            'nomor' => $jumlahBarisData + 1,
            'jenis_transaksi' => 'Masuk',
            'bhp_id' => $bhp_id,
            'satuan' => $satuan,
            // Menambahkan jenis transaksi
        ]);



        BarangHabisPakai::create($request->all());
        notify()->success('Laravel Notify is awesome!');

        return redirect()->route('admin.bhp')->with('success', 'Barang habis pakai berhasil ditambahkan!');
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function dataBHP()
    {
        $bhp = BarangHabisPakai::select([
            'jenis_barang',
            'satuan',
            // DB::raw('COUNT(jenis_barang) as jumlah_jenis_barang'), // Menghitung jumlah jenis_barang
            DB::raw('COALESCE(SUM(CASE WHEN jenis_transaksi = "Keluar" THEN -jumlah ELSE jumlah END), 0) as jumlah'),

        ])
            ->groupBy('jenis_barang', 'satuan')
            ->get();

        // $satuan = BarangHabisPakai::select([
        //     'satuan'
        // ]);

        $nomor = 1;
        // $maxJumlah = $bhp->max('jumlah_jenis_barang'); // Mengambil nilai maksimum dari jumlah_jenis_barang            
        return Datatables::of($bhp)
            // ->addColumn('satuan', function ($row) use ($satuan) {
            //     // Menggunakan nomor yang terus bertambah   
            //     return $satuan;
            // })
            ->addColumn('nomor', function ($row) use (&$nomor) {
                // Menggunakan nomor yang terus bertambah   
                return $nomor++;
            })
            ->addColumn('jumlah', function ($row) {
                // Menggunakan COALESCE untuk menangani nilai null atau 0
                return $row->jumlah ?? 0;
            })
            ->addColumn('action', function ($bhp) {
                return '<a href="/admin/barang-habis-pakai/' . $bhp->jenis_barang . '/hapus-bhp" class="btn-act text-dark me-1" id="hapus-bhp">
                            <img src="' . asset('images/icons/trash.svg') . '" alt="">
                            </a>';
            })


            ->make(true);
    }

    public function jenisBHP(Request $request)
    {
        $request->validate([
            'jenis_barang' => 'required|string|max:50|regex:/^[^0-9]+$/',
            'bhp_id' => 'required|string|max:50|regex:/^.+$/',
            'satuan' => 'required|string|max:10|regex:/^[^0-9]+$/',
            'jumlah' => 'required|integer|max:2147483647|gt:0',

        ], [
            'jenis_barang.required' => 'jenis barang wajib diisi!',
            'jenis_barang.string' => 'jenis barang harus berupa text!',
            'jenis_barang.max' => 'jenis barang tidak boleh lebih dari 50 karakter!',
            'jenis_barang.regex' => 'jenis barang harus berupa text!',
            'bhp_id.required' => 'BHP ID wajib diisi unik!',
            'bhp_id.string' => 'BHP ID harus berupa huruf, angka atau kombinasi keduanya!',
            'bhp_id.max' => 'BHP ID tidak boleh lebih dari 10 karakter!',
            'bhp_id.regex' => 'Isiannya harus berupa huruf, angka atau kombinasi keduanya!',
            'satuan.required' => 'satuan wajib diisi!',
            'satuan.string' => 'satuan harus berupa text!',
            'satuan.max' => 'satuan tidak boleh lebih dari 10 karakter!',
            'satuan.regex' => 'satuan harus berupa text!',
            'jumlah.required' => 'jumlah wajib diisi!',
            'jumlah.integer' => 'jumlah harus berupa angka!',
            'jumlah.max' => 'jumlah tidak boleh lebih dari 9 digit!',
            'jumlah.gt' => 'jumlah barang yang diisikan harus lebih dari 0!',
        ]);


        try {

            $jenis_bhp = BarangHabisPakai::where('jenis_barang', $request->jenis_barang)
                ->orWhere('bhp_id', $request->bhp_id)
                ->first();
            if ($jenis_bhp) {
                throw new \Exception('Jenis Barang dan BHP ID harus unik! Silakan cek kembali apakah jenis barang atau BHP ID sudah pernah didaftarkan!');
            }
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, simpan pesan kesalahan dalam session
            return redirect()->back()->with('error', $e->getMessage());
        }

        // Menghitung jumlah baris data yang sudah ada
        $jumlahBarisData = BarangHabisPakai::count();


        $request->merge([
            'nomor' => $jumlahBarisData + 1,
            'jenis_transaksi' => 'Masuk', // Menambahkan jenis transaksi
        ]);

        BarangHabisPakai::create($request->all());

        return redirect()->route('admin.bhp')->with('success', 'Barang habis pakai berhasil ditambahkan!');
    }


    public function hapusBHP($hapusBHP)
    {

        BarangHabisPakai::where('jenis_barang', $hapusBHP)->delete();
        AmbilBarangHabisPakai::where('jenis_barang', $hapusBHP)->delete();

        return redirect()->route('admin.bhp')->with('success', 'Stok Barang Habis Pakai berhasil dihapus!');
    }

    public function dataTransaksiBHP(Request $request)
    {

        $transaksiBHP = BarangHabisPakai::get();


        $nomor = 1; // Inisialisasi nomor awal

        return Datatables::of($transaksiBHP)
            ->addColumn('nomor', function ($row) use (&$nomor) {
                // Menggunakan nomor yang terus bertambah
                return $nomor++;
            })
            ->addColumn('tanggal', function ($transaksiBHP) {
                // return $transaksiBHP->created_at ? $transaksiBHP->created_at->setTimezone('Asia/Jakarta'): 'N/A';
                return $transaksiBHP->created_at ? $transaksiBHP->created_at->setTimezone('Asia/Jakarta')->format('d/m/Y') : 'N/A';
            })

            ->addColumn('action', function ($transaksiBHP) {
                if ($transaksiBHP->jenis_transaksi == "Keluar") {
                    return '<a href="/admin/barang-habis-pakai/' . $transaksiBHP->id . '/hapus-transaksi-bhp" class="btn-act text-dark me-1" id="hapus-transaksi-bhp">
                            <img src="' . asset('images/icons/trash.svg') . '" alt="">
                            </a>';
                } else {
                    return '
                            <a href="/admin/barang-habis-pakai/' . $transaksiBHP->id . '/hapus-transaksi-bhp" class="btn-act text-dark me-1" id="hapus-transaksi-bhp">
                            <img src="' . asset('images/icons/trash.svg') . '" alt="">
                            </a>
                            <a href="/admin/barang-habis-pakai/' . $transaksiBHP->id . '/edit-form" class="btn-act text-dark me-1">
                            <img src="' . asset('images/icons/edit.svg') . '" alt="">
                            </a>
                            ';
                }
            })

            ->rawColumns(['rounded_color_name', 'action']) // Specify that 'rounded_color_name' contains HTML
            ->make(true);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editTransaksiBHP(Request $request, $id)
    {

        $request->validate([
            'jenis_barang' => 'required|string',
            'jumlah' => 'required|integer|max:2147483647|gt:0',
        ], [
            'jenis_barang.required' => 'jenis barang wajib diisi!',
            'jenis_barang.string' => 'jenis barang harus berupa string!',
            'jumlah.required' => 'jumlah wajib diisi!',
            'jumlah.integer' => 'jumlah harus berupa integer!',
            'jumlah.max' => 'jumlah tidak boleh lebih dari 9 digit!',
            'jumlah.gt' => 'jumlah penambahan barang habis pakai harus lebh dari 0!',
        ]);

        $bhp = BarangHabisPakai::find($id);

        $bhp->jenis_barang = $request->jenis_barang;
        $bhp->jumlah = $request->jumlah;
        // Tambahkan update untuk field lainnya sesuai kebutuhan

        $bhp->save();

        return redirect()->route('admin.bhp')->with('success', 'Data transaksi berhasil diupdate!');
    }

    public function hapusTransaksiBHP($id)
    {

        // Cari barang berdasarkan kode_barang
        $bhp = BarangHabisPakai::where('id', $id)->first();

        $nomorSebelum = $bhp->nomor;

        if (!$bhp) {
            return redirect()->route('admin.bhp')->with('error', 'Transaksi Barang Habis Pakai tidak ditemukan!');
        }

        if ($bhp->jenis_transaksi == "Keluar") {
            $ambilBhp = AmbilBarangHabisPakai::where('created_at', $bhp->created_at)->first();
            if (!$ambilBhp) {
                return redirect()->route('admin.bhp')->with('error', 'Transaksi Barang Habis Pakai tidak ditemukan!');
            }
            $nomorSebelum2 = $ambilBhp->nomor;
            // Hapus barang
            $bhp->delete();
            $ambilBhp->delete();
            AmbilBarangHabisPakai::where('nomor', '>', $nomorSebelum2)->decrement('nomor');
        } else {
            $bhp->delete();
        }
        BarangHabisPakai::where('nomor', '>', $nomorSebelum)->decrement('nomor');

        return redirect()->route('admin.bhp')->with('success', 'Transaksi Barang Habis Pakai berhasil dihapus!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function notifikasi(Request $request)
    // {
    //     $barang = BarangHabisPakai::where('jenis_barang', $request->jenis_barang)->first();


    //     try {
    //         if (!$barang) {
    //             throw new \Exception('Terdapat barang yang belum tersedia, mohon cek barang');
    //         }

    //         // Ambil total jumlah berdasarkan jenis transaksi "Keluar"
    //         $jumlahKeluar = BarangHabisPakai::where('jenis_barang', $request->jenis_barang)
    //             ->where('jenis_transaksi', 'Keluar')
    //             ->sum('jumlah');

    //         $jumlahMasuk = BarangHabisPakai::where('jenis_barang', $request->jenis_barang)
    //             ->where('jenis_transaksi', 'Masuk')
    //             ->sum('jumlah');

    //         // Hitung jumlah yang seharusnya tersedia setelah pengambilan
    //         $stokTersedia = $jumlahMasuk - $jumlahKeluar;

    //          if($stokTersedia<5){
    //             throw new \Exception('Terdapat stok barang hampir habis. Mohon cek stok barang');
                
    //          }

    //     } catch (\Exception $e) {
    //         // Jika terjadi kesalahan, simpan pesan kesalahan dalam session

    //         return redirect()->route('admin.bhp')->with('error', $e->getMessage());
    //     }
    // }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
}
