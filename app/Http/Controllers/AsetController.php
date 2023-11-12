<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Rules\NotTomorrow;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AsetController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => ['required', 'string', 'max:255', 'regex:/^\d+$/'], // Hanya menerima string angka
            'nup' => ['required', 'string', 'max:255', 'regex:/^\d+$/'], // Hanya menerima string angka
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

        $jumlahBarisData = Aset::count();

        $request->merge(['nomor' => $jumlahBarisData + 1]);

        Aset::create($request->all());

        return redirect()->route('admin.data-master')->with('success', 'Aset berhasil ditambahkan!');
    }

    public function update(Request $request, $kode_barang, $nup)
    {
        $request->validate([
            'tanggal_masuk' => ['required', 'date', new NotTomorrow], // Use the custom rule
            'kode_ruang' => 'required|string',
            'kondisi' => 'required|string',
            'tanggal_pemeliharaan_terakhir' =>  ['nullable', 'date', new NotTomorrow],
            'deskripsi' => 'required|string',
        ], [
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
            $aset->delete();

            return redirect()->route('admin.data-master')->with('success', 'Aset berhasil dihapus!');
        } else {
            return redirect()->route('admin.data-master')->with('error', 'Aset tidak ditemukan!');
        }
    }

    public function data()
    {
        $aset = Aset::with(['barang', 'ruang'])->get();

        return DataTables::of($aset)
            ->addColumn('tanggal_masuk', function ($aset) {
                // Format tanggal sesuai kebutuhan Anda
                return $aset->tanggal_masuk->format('d-m-Y');
            })
            ->addColumn('jenis_barang', function ($aset) {
                return '<div class="rounded-background rounded-pill" style="background-color: ' . $aset->barang->warna . ';">' . $aset->barang->nama . '</div>';
            })
            ->addColumn('nama_ruang', function ($aset) {
                return $aset->ruang->nama;
            })
            ->addColumn('action', function ($aset) {
                return '<a href="/admin/data-master/' . $aset->kode_barang . '/' . $aset->nup . '/edit" class="btn-act text-dark me-1">
                         <img src="' . asset('images/icons/edit.svg') . '" alt="">
                     </a>
                     <a href="/admin/data-master/' . $aset->kode_barang . '/' . $aset->nup . '/hapus" id="hapus-aset" class="btn-act text-dark me-1">
                         <img src="' . asset('images/icons/trash.svg') . '" alt="">
                     </a>
                     <a href="/admin/data-master/' . $aset->kode_barang . '/' . $aset->nup . '/detail" class="btn-act text-dark me-1">
                         <img src="' . asset('images/icons/eye.svg') . '" alt="">
                     </a>';
            })
            ->rawColumns(['jenis_barang', 'action'])
            ->make(true);
    }
}
