<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Aset;
use App\Models\Ruang;
use Barryvdh\DomPDF\PDF;
use App\Rules\NotTomorrow;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class AsetController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => ['required', 'string', 'max:255', 'regex:/^\d+$/'], // Hanya menerima string angka
            'nup' => ['required', 'string', 'max:255', 'regex:/^\d+$/'], // Hanya menerima string angka
            'merek' => 'required|string',
            'tanggal_masuk' => ['required', 'date', new NotTomorrow], // Use the custom rule
            'kode_ruang' => 'required|string',
            'kondisi' => 'required|string',
            'tanggal_pemeliharaan_terakhir' =>  ['nullable', 'date', new NotTomorrow],
            'deskripsi' => 'required|string',
        ], [
            'kode_barang.required' => 'Kode Barang wajib diisi!',
            'kode_barang.string' => 'Kode Barang harus berupa string!',
            'kode_barang.max' => 'Kode Barang tidak boleh lebih dari :max karakter!',
            'kode_barang.regex' => 'Kode Barang harus berupa string angka!',
            'nup.required' => 'NUP wajib diisi!',
            'nup.string' => 'NUP harus berupa string!',
            'nup.max' => 'NUP tidak boleh lebih dari :max karakter!',
            'nup.regex' => 'NUP harus berupa string angka!',
            'merek.required' => 'Merek wajib diisi!',
            'merek.string' => 'Merek harus berupa string!',
            'tanggal_masuk.required' => 'Tanggal Masuk wajib diisi!',
            'tanggal_masuk.date' => 'Format Tanggal Masuk tidak valid!',
            'kode_ruang.required' => 'Ruang wajib diisi!',
            'kode_ruang.string' => 'Ruang harus berupa string!',
            'kondisi.required' => 'Kondisi wajib diisi!',
            'kondisi.string' => 'Kondisi harus berupa string!',
            'tanggal_pemeliharaan_terakhir.date' => 'Format Tanggal Pemeliharaan Terakhir tidak valid!',
            'deskripsi.required' => 'Deskripsi wajib diisi!',
            'deskripsi.string' => 'Deskripsi harus berupa string!',
        ]);

        $tanggal_pemeliharaan_terakhir = $request->kode_barang != "3050204004" ? null : $request->tanggal_pemeliharaan_terakhir;

        $request->merge([
            'tanggal_pemeliharaan_terakhir' => $tanggal_pemeliharaan_terakhir,
            'nomor' => Aset::count() + 1,
        ]);

        Aset::create($request->all());

        return redirect()->route('admin.data-master')->with('success', 'Aset berhasil ditambahkan!');
    }

    public function update(Request $request, $kode_barang, $nup)
    {
        $request->validate([
            'merek' => 'required|string',
            'tanggal_masuk' => ['required', 'date', new NotTomorrow], // Use the custom rule
            'kode_ruang' => 'required|string',
            'kondisi' => 'required|string',
            'tanggal_pemeliharaan_terakhir' =>  ['nullable', 'date', new NotTomorrow],
            'deskripsi' => 'required|string',
        ], [
            'merek.required' => 'Merek wajib diisi!',
            'merek.string' => 'Merek harus berupa string!',
            'tanggal_masuk.required' => 'Tanggal Masuk wajib diisi!',
            'tanggal_masuk.date' => 'Format Tanggal Masuk tidak valid!',
            'kode_ruang.required' => 'Ruang wajib diisi!',
            'kode_ruang.string' => 'Ruang harus berupa string!',
            'kondisi.required' => 'Kondisi wajib diisi!',
            'kondisi.string' => 'Kondisi harus berupa string!',
            'tanggal_pemeliharaan_terakhir.date' => 'Format Tanggal Pemeliharaan Terakhir tidak valid!',
            'deskripsi.required' => 'Deskripsi wajib diisi!',
            'deskripsi.string' => 'Deskripsi harus berupa string!',
        ]);

        $aset = Aset::where('kode_barang', $kode_barang)
            ->where('nup', $nup)
            ->firstOrFail();

        $aset->merek = $request->merek;
        $aset->tanggal_masuk = $request->tanggal_masuk;
        $aset->kode_ruang = $request->kode_ruang;
        $aset->kondisi = $request->kondisi;
        $aset->tanggal_pemeliharaan_terakhir = $request->tanggal_pemeliharaan_terakhir;
        $aset->deskripsi = $request->deskripsi;

        $aset->save();

        return redirect()->route('admin.data-master')->with('success', 'Aset berhasil diupdate!');
    }

    public function remove($kode_barang, $nup)
    {
        $aset = Aset::where('kode_barang', $kode_barang)
            ->where('nup', $nup)
            ->firstOrFail();

        if ($aset) {

            $nomorSebelum = $aset->nomor;


            $aset->delete();

            // Update nomor untuk baris data yang memiliki nomor lebih besar dari nomor sebelumnya
            Aset::where('nomor', '>', $nomorSebelum)->decrement('nomor');

            return redirect()->route('admin.data-master')->with('success', 'Aset berhasil dihapus!');
        } else {
            return redirect()->route('admin.data-master')->with('error', 'Aset tidak ditemukan!');
        }
    }

    public function data(Request $request)
    {
        $aset = Aset::with(['barang', 'ruang']);

        // Tambahkan kondisi filter jika ada
        if ($request->filter_barang != null) {
            $aset->where('kode_barang', $request->filter_barang);
        }

        if ($request->filter_ruang != null) {
            $aset->where('kode_ruang', $request->filter_ruang);
        }

        if ($request->filter_bulan != null) {
            $aset->whereMonth('tanggal_masuk', $request->filter_bulan);
        }

        if ($request->filter_tahun != null) {
            $aset->whereYear('tanggal_masuk', $request->filter_tahun);
        }

        // Perhatikan bahwa kita menggunakan ->get() di sini, bukan ->get() pada $aset
        // $aset_filtered = $aset->get();

        return DataTables::of($aset)
            ->addColumn('tanggal_masuk', function ($row) {
                // Format tanggal sesuai kebutuhan Anda
                return $row->tanggal_masuk->format('d/m/Y');
            })
            ->addColumn('jenis_barang', function ($row) {
                return '<div class="rounded-background rounded-pill" style="background-color: ' . $row->barang->warna . ';">' . $row->barang->nama . '</div>';
            })
            ->addColumn('nama_ruang', function ($row) {
                return $row->ruang ? $row->ruang->nama : '-';
            })
            ->addColumn('action', function ($row) {
                return '<a href="/admin/data-master/' . $row->kode_barang . '/' . $row->nup . '/edit" class="btn-act text-dark me-1">
                 <img src="' . asset('images/icons/edit.svg') . '" alt="">
             </a>
             <a href="/admin/data-master/' . $row->kode_barang . '/' . $row->nup . '/hapus" id="hapus-aset" class="btn-act text-dark me-1">
                 <img src="' . asset('images/icons/trash.svg') . '" alt="">
             </a>
             <a href="/admin/data-master/' . $row->kode_barang . '/' . $row->nup . '/detail" class="btn-act text-dark me-1">
                 <img src="' . asset('images/icons/eye.svg') . '" alt="">
             </a>';
            })
            ->rawColumns(['jenis_barang', 'action'])
            ->make(true);
    }



    // public function viewDbr(Request $request) {
    //     $ruang = Ruang::where('kode_ruang', $request->filter_ruang)->firstOrFail();
    //     $created_at = \Carbon\Carbon::now()->format('d/m/Y');

    //     $asets = Aset::with(['barang', 'ruang'])
    //         ->where('kode_ruang', $request->filter_ruang)
    //         ->orderBy('kode_barang', 'asc')
    //         ->get();

    //     $pdf = PDF::loadView('export.format-dbr', compact('asets', 'ruang', 'created_at'));

    //     return $pdf->download('dbr.pdf');
    // }

    // public function eksporDBR(Request $request)
    // {
    //     $ruang = Ruang::where('kode_ruang', $request->filter_ruang)->firstOrFail();
    //     $created_at = \Carbon\Carbon::now()->format('d/m/Y');

    //     $asets = Aset::with(['barang', 'ruang'])
    //         ->where('kode_ruang', $request->filter_ruang)
    //         ->orderBy('kode_barang', 'asc')
    //         ->get();

    //     $mpdf = new \Mpdf\Mpdf();
    //     $mpdf->WriteHTML(view('export.format-dbr', compact('asets', 'ruang', 'created_at')));
    //     $mpdf->Output('download-dbr.pdf', 'D');
    // }

    public function eksporDBR(Request $request)
    {
        $ruang = Ruang::where('kode_ruang', $request->filter_ruang)->firstOrFail();
        $created_at = \Carbon\Carbon::now()->setTimezone('Asia/Jakarta')->format('d/m/Y');
        // Mencari aset berdasarkan kode ruang
        $asets = Aset::with(['barang', 'ruang'])
            ->where('kode_ruang', $request->filter_ruang)
            ->orderBy('kode_barang', 'asc')
            ->get();

        // Memeriksa apakah ada aset untuk ruang tertentu
        if ($asets->isEmpty()) {
            // Jika tidak ada aset, kembalikan pesan kesalahan
            return redirect()->back()->with('error', 'Tidak ditemukan aset untuk ruang ini!');
        }
        
        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('export.format-dbr', compact('asets', 'ruang', 'created_at')));
        
        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');
        
        // Render the HTML as PDF
        $dompdf->render();
        
        // Set the file name
        $filename = 'dbr-' . $ruang->kode_ruang . '.pdf';
        
        // Output the generated PDF to Browser with the specified filename
        return $dompdf->stream($filename, [
                'Attachment' => 1, // 0: Inline, 1: Attachment (download)
            ]);
        }
        
        // return view('export.format-dbr', compact('asets', 'ruang', 'created_at'));
}
