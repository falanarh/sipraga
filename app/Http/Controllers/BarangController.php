<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class BarangController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => [
                'required',
                'string',
                Rule::unique('barangs')->ignore($request->id),
            ],
            'nama' => 'required|string',
            'warna' => 'required|string|max:7',
        ], [
            'kode_barang.required' => 'Kode Barang wajib diisi!',
            'kode_barang.string' => 'Kode Barang harus berupa string!',
            'kode_barang.unique' => 'Kode Barang sudah digunakan!',
            'nama.required' => 'Nama wajib diisi!',
            'nama.string' => 'Nama harus berupa string!',
            'warna.required' => 'Warna wajib diisi!',
            'warna.string' => 'Warna harus berupa string!',
            'warna.max' => 'Warna tidak boleh lebih dari 7 karakter!',
        ]);

        // Menghitung jumlah baris data yang sudah ada
        $jumlahBarisData = Barang::count();

        // Menambahkan kolom nomor
        $request->merge(['nomor' => $jumlahBarisData + 1]);

        // Menyimpan data baru ke dalam tabel
        Barang::create($request->all());

        return redirect()->route('admin.data-master')->with('success', 'Barang berhasil ditambahkan!');
    }

    public function update(Request $request, $kode_barang)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'warna' => [
                'required',
                'string',
                'max:7',
                Rule::unique('barangs')->ignore($request->id),
            ],

        ], [
            'nama.required' => 'Nama wajib diisi!',
            'nama.string' => 'Nama harus berupa string!',
            'nama.max' => 'Nama tidak boleh melebihi 255 karakter!',
            'warna.required' => 'Warna wajib diisi!',
            'warna.string' => 'Warna harus berupa string!',
            'warna.max' => 'Warna tidak boleh lebih dari 7 karakter!',
            'warna.unique' => 'Warna barang sudah digunakan!',
        ]);

        $barang = Barang::find($kode_barang);

        $barang->nama = $request->nama;
        $barang->warna = $request->warna;
        // Tambahkan update untuk field lainnya sesuai kebutuhan

        $barang->save();

        return redirect()->route('admin.data-master')->with('success', 'Barang berhasil diupdate!');
    }

    public function remove($kode_barang)
    {
        // Cari barang berdasarkan kode_barang
        $barang = Barang::where('kode_barang', $kode_barang)->first();

        // Periksa apakah barang ditemukan
        if ($barang) {

            $nomorSebelum = $barang->nomor;
    
            // Hapus barang
            $barang->delete();

            // Update nomor untuk baris data yang memiliki nomor lebih besar dari nomor sebelumnya
            Barang::where('nomor', '>', $nomorSebelum)->decrement('nomor');
            
            // Redirect dengan pesan sukses
            return redirect()->route('admin.data-master')->with('success', 'Barang berhasil dihapus!');
        } else {
            // Redirect dengan pesan error jika barang tidak ditemukan
            return redirect()->route('admin.data-master')->with('error', 'Barang tidak ditemukan!');
        }
    }


    public function data()
    {
        $barang = Barang::select(['nomor', 'kode_barang', 'nama', 'warna']);

        return Datatables::of($barang)
            ->addColumn('rounded_color_name', function ($barang) {
                return '<div class="rounded-background rounded-pill" style=" background-color:' . $barang->warna . ';">' . $barang->nama . '</div>';
            })
            ->addColumn('action', function ($barang) {
                return '<a href="/admin/data-master/' . $barang->kode_barang . '/edit" class="btn-act text-dark me-1">
                         <img src="' . asset('images/icons/edit.svg') . '" alt="">
                     </a>
                     <a href="/admin/data-master/' . $barang->kode_barang . '/hapus" class="btn-act text-dark me-1" id="hapus-jenis">
                         <img src="' . asset('images/icons/trash.svg') . '" alt="">
                     </a>';
            })
            ->rawColumns(['rounded_color_name', 'action']) // Specify that 'rounded_color_name' contains HTML
            ->make(true);
    }
}
