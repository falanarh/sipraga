<?php

namespace App\Http\Controllers;

use id;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\BarangHabisPakai;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\AmbilBarangHabisPakai;
use App\Models\Ruang;
use App\Models\User;
use App\Rules\NotTomorrow;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

class AmbilBarangHabisPakaiController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $barang = BarangHabisPakai::where('jenis_barang', $request->jenis_barang)->first();



        $request->validate([
            'jenis_barang' => 'required',
            'nama_ruang' => 'required',
            'jumlah_ambilBHP' => 'required|integer|max:2147483647|gt:0',
            'keterangan' => 'nullable|string|max:50|regex:/^[A-Za-z\s]+$/'

        ], [
            'jenis_barang.required' => 'Jenis barang habis pakai wajib dipilih!',
            'nama_ruang.required' => 'Ruang wajib dipilih!',
            'jumlah_ambilBHP.required' => 'Jumlah pengambilan barang habis pakai wajib diisi!',
            'jumlah_ambilBHP.integer' => 'Jumlah pengambilan barang habis pakai harus berupa angka!',
            'jumlah_ambilBHP.max' => 'Jumlah pengambilan barang habis pakai tidak boleh lebih dari 9 digit!',
            'jumlah_ambilBHP.gt' => 'Jumlah pengambilan barang habis pakai harus lebih dari 0',
            'keterangan.string' => 'Keterangan yang diisi harus berupa text!',
            'keterangan.max' => 'Keterangan yang diisi maksimal 50 karakter!',
            'keterangan.regex' => 'Keterangan yang diisi harus berupa text!'
        ]);

        try {
            if (!$barang) {
                throw new \Exception('Stok barang belum tersedia. Silakan hubungi pihak administrasi BAU');
            }

            // Ambil total jumlah berdasarkan jenis transaksi "Keluar"
            $jumlahKeluar = BarangHabisPakai::where('jenis_barang', $request->jenis_barang)
                ->where('jenis_transaksi', 'Keluar')
                ->sum('jumlah');

            $jumlahMasuk = BarangHabisPakai::where('jenis_barang', $request->jenis_barang)
                ->where('jenis_transaksi', 'Masuk')
                ->sum('jumlah');

            // Hitung jumlah yang seharusnya tersedia setelah pengambilan
            $stokTersedia = $jumlahMasuk - $jumlahKeluar;

            //  if($stokTersedia<5){
            //     notify()->success('Laravel Notify is awesome!');
            //  }
            

            if ($stokTersedia == null) {
                throw new \Exception('Stok barang belum tersedia. Silakan hubungi pihak administrasi BAU');
            } elseif ($request->jumlah_ambilBHP > $stokTersedia) {
                throw new \Exception('Jumlah pengambilan melebihi stok yang tersedia. Silakan hubungi pihak administrasi BAU');
            }
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, simpan pesan kesalahan dalam session
            
            return redirect()->back()->with('error', $e->getMessage());
        }


        $user = Auth::user();
        $jenis_barang_bhp = BarangHabisPakai::where('jenis_barang',$request->jenis_barang)->first();
        $bhp_id = $jenis_barang_bhp -> bhp_id;
        $satuan = $jenis_barang_bhp-> satuan;

        $request->merge(['pemakai_bhp_id' => $user->user_id]);
        $request->merge(['bhp_id' => $bhp_id]);
        $request->merge(['satuan' => $satuan]);
        // Menghitung jumlah baris data yang sudah ada
        $jumlahBarisData = AmbilBarangHabisPakai::count();
        // Menambahkan kolom nomor
        $request->merge(['nomor' => $jumlahBarisData + 1]);

        // AmbilBarangHabisPakai::create($request->all());
        // Buat data untuk AmbilBarangHabisPakai
        $ambilBarang = AmbilBarangHabisPakai::create($request->all());


        // Buat data untuk BarangHabisPakai
        // Menghitung jumlah baris data yang sudah ada
        $jumlahBarisData = BarangHabisPakai::count();
        BarangHabisPakai::create([
            'bhp_id' => $ambilBarang->bhp_id,
            'jenis_barang' => $ambilBarang->jenis_barang,
            'jumlah' => $ambilBarang->jumlah_ambilBHP,
            'satuan' => $ambilBarang->satuan,
            'jenis_transaksi' => 'Keluar',
            'nomor' => $jumlahBarisData + 1,
            'satuan'=> $ambilBarang -> satuan,
        ]);

        
        return redirect()->route('pemakaibhp.pengambilan')->with('success', 'Pengambilan Barang Habis Pakai, berhasil!');
        
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dataAmbilBHP(Request $request)
    {
        $Ambil_bhp = AmbilBarangHabisPakai::get();

        try {

            $nomor = 1; // Inisialisasi nomor awal

            return Datatables::of($Ambil_bhp)
                ->addColumn('nomor', function ($row) use (&$nomor) {
                    // Menggunakan nomor yang terus bertambah
                    return $nomor++;
                })
                ->addColumn('nama_pengambil', function ($row) {
                    return $row->user ? $row->user->name : '-';
                })
                ->addColumn('tanggal', function ($row) {
                    return $row->created_at ? $row->created_at->setTimezone('Asia/Jakarta')->format('d/m/Y') : 'N/A';
                })
                ->addColumn('action', function ($row) {
                    return '<a href="/admin/barang-habis-pakai/' . $row->pengambilan_bhp_id . '/hapus-pengambilan-bhp" class="btn-act text-dark me-1" id="hapus-pengambilan-bhp">
                         <img src="' . asset('images/icons/trash.svg') . '" alt="">
                         </a>';
                })
                ->make(true);

            return response()->json(['message' => 'Data berhasil disimpan!']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage('Terdapat kesalahan pada pengisian data')]);
        }
    }


    public function eksporBHP(Request $request)
    {

        $tanggalprint = \Carbon\Carbon::now()->setTimezone('Asia/Jakarta');

        $request->validate([
            'pengambil' => 'required',
            'tanggal' => 'required', 'date', new NotTomorrow
        ], [
            'pengambil.required' => 'Pengambil wajid diisi!',
            'tanggal.required' => 'Tanggal wajib diisi',
            'tanggal.date' => 'Format Tanggal tidak valid!',
        ]);


        $tanggal = Carbon::parse($request->tanggal)->format('Y-m-d');
        // Ambil satu objek
        $bhp = AmbilBarangHabisPakai::whereDate('created_at', $tanggal)
            ->where('pemakai_bhp_id', $request->pengambil)
            ->first();


        $ambilbhps = AmbilBarangHabisPakai::whereDate('created_at', $tanggal)
            ->where('pemakai_bhp_id', $request->pengambil)
            ->get();

        $pengambilbhp = User::where('user_id', $request->pengambil)
            ->first();
        $admin = Auth::user();

        $tanggal_formatted = Carbon::parse($request->tanggal)->format('d-m-Y');

        if ($ambilbhps->count() == 0) {
            // Jika tidak ada aset, kembalikan pesan kesalahan
            return redirect()->back()->with('error', 'Pengambilan BHP pada tanggal tersebut tidak ditemukan!');
        }

        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('export.format-bhp', compact('admin', 'pengambilbhp', 'tanggal_formatted', 'bhp', 'ambilbhps')));

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Set the file name
        $filename = 'bhp-' . $tanggalprint . '.pdf';

        // Session::flash('success', 'Data Pengambilan Barang Habis Pakai berhasil dicetak!');

        // Output the generated PDF to Browser with the specified filename
        return $dompdf->stream($filename, [
            'Attachment' => 1, // 0: Inline, 1: Attachment (download)
        ]);
        // return redirect()->route('admin.bhp')->with('success', 'Data Pengambilan Barang Habis Pakai berhasil dicetak!');

    }

    public function hapusPengambilanBHP($pengambilan_bhp_id)
    {


        $Ambilbhp = AmbilBarangHabisPakai::where('pengambilan_bhp_id', $pengambilan_bhp_id)->first();


        // Periksa apakah barang ditemukan
        if ($Ambilbhp) {
            $bhp = BarangHabisPakai::where('created_at', $Ambilbhp->created_at)->first();

            if ($bhp) {
                // Hapus barang
                $Ambilbhp->delete();
                $bhp->delete();

                // Redirect dengan pesan sukses
                return redirect()->route('admin.bhp')->with('success', 'Data Pengambilan Barang Habis Pakai berhasil dihapus!');
            }
            $Ambilbhp->delete();
            return redirect()->route('admin.bhp')->with('success', 'Data Pengambilan Barang Habis Pakai berhasil dihapus!');
        }

        // Redirect dengan pesan error jika barang tidak ditemukan
        return redirect()->route('admin.bhp')->with('error', 'Data Pengambilan Barang Habis Pakai tidak ditemukan!');
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
