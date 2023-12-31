<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Ruang;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class RuangController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'kode_ruang' => [
                'required',
                'string',
                'max:255',
                Rule::unique('ruangs')->ignore($request->id),
            ],
            'nama' => 'required|string|max:255',
            'gedung' => 'required|integer',
            'lantai' => 'required|integer',
            'kapasitas' => 'required|integer',
        ], [
            'kode_ruang.required' => 'Kode Ruang wajib diisi!',
            'kode_ruang.string' => 'Kode Ruang harus berupa string!',
            'kode_ruang.max' => 'Kode Ruang tidak boleh melebihi 255 karakter!',
            'kode_ruang.unique' => 'Kode Ruang sudah digunakan!',
            'nama.required' => 'Nama wajib diisi!',
            'nama.string' => 'Nama harus berupa string!',
            'nama.max' => 'Nama tidak boleh melebihi 255 karakter!',
            'gedung.required' => 'Gedung wajib diisi!',
            'gedung.integer' => 'Gedung harus berupa angka!',
            'lantai.required' => 'Lantai wajib diisi!',
            'lantai.integer' => 'Lantai harus berupa angka!',
            'kapasitas.required' => 'Kapasitas wajib diisi!',
            'kapasitas.integer' => 'Kapasitas harus berupa angka!',
        ]);

        // Menghitung jumlah baris data yang sudah ada
        $jumlahBarisData = Ruang::count();

        // Menambahkan kolom nomor
        $request->merge(['nomor' => $jumlahBarisData + 1]);

        // Menyimpan data baru ke dalam tabel
        Ruang::create($request->all());

        // Redirect dengan pesan sukses
        return redirect()
            ->route('admin.data-ruangan') // Ganti dengan nama route yang sesuai
            ->with('success', 'Ruang berhasil ditambahkan');
    }

    public function update(Request $request, $kode_ruang)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'gedung' => 'required|integer',
            'lantai' => 'required|integer',
            'kapasitas' => 'required|integer',
        ], [
            'nama.required' => 'Nama wajib diisi!',
            'nama.string' => 'Nama harus berupa string!',
            'nama.max' => 'Nama tidak boleh melebihi 255 karakter!',
            'gedung.required' => 'Gedung wajib diisi!',
            'gedung.integer' => 'Gedung harus berupa angka!',
            'lantai.required' => 'Lantai wajib diisi!',
            'lantai.integer' => 'Lantai harus berupa angka!',
            'kapasitas.required' => 'Kapasitas wajib diisi!',
            'kapasitas.integer' => 'Kapasitas harus berupa angka!',
        ]);

        $ruang = Ruang::find($kode_ruang);

        $ruang->nama = $request->nama;
        $ruang->gedung = $request->gedung;
        $ruang->lantai = $request->lantai;
        $ruang->kapasitas = $request->kapasitas;

        $ruang->save();

        return redirect()->route('admin.data-ruangan')-> with('success', 'Ruang berhasil diupdate!');
    }

    public function remove($kode_ruang){
        $ruang = Ruang::where('kode_ruang', $kode_ruang)->first();

        if($ruang){
            $nomorSebelum = $ruang->nomor;

            $ruang->delete();

            // Update nomor untuk baris data yang memiliki nomor lebih besar dari nomor sebelumnya
            Ruang::where('nomor', '>', $nomorSebelum)->decrement('nomor');

            return redirect()->route('admin.data-ruangan')->with('success', 'Ruang berhasil dihapus!');
        } else {
            return redirect()->route('admin.data-ruangan')->with('error', 'Ruang tidak ditemukan!');
        }
    }

    public function data()
    {
        $ruang = Ruang::select(['nomor', 'kode_ruang', 'nama', 'gedung', 'lantai', 'kapasitas']);

        return Datatables::of($ruang)
            ->addColumn('action', function ($ruang) {
                return '<a href="/admin/data-ruangan/' . $ruang->kode_ruang . '/edit" class="btn-act text-dark me-1">
                             <img src="' . asset('images/icons/edit.svg') . '" alt="">
                         </a>
                         <a href="/admin/data-ruangan/' . $ruang->kode_ruang . '/hapus" class="btn-act text-dark me-1" id="hapus-ruang">
                             <img src="' . asset('images/icons/trash.svg') . '" alt="">
                         </a>';
            })
            ->make(true);
    }
  
    public function getRuangs(){
        try {
            $ruangs = Ruang::select('kode_ruang', 'nama', 'gedung', 'lantai', 'kapasitas')->get();
        
            $response = [
                'status_code' => 200,
                'message' => 'Berhasil mendapatkan data ruangan!',
                'data' => $ruangs,
            ];
        
            return response()->json($response, 200);
        } catch (Exception $e) {
            $response = [
                'status_code' => 500,
                'error' => $e->getMessage(),
            ];
        
            return response()->json($response, 500);
        }        
    }

    public function getRuangsForCalendar() {
        $ruangs = Ruang::select('kode_ruang', 'nama', 'gedung', 'lantai', 'kapasitas')->get();
    
        $ruangsForCalendar = $ruangs->map(function ($ruang) {
            return [
                'id' => $ruang->kode_ruang,
                'title' => $ruang->nama,
                // Jika Anda ingin menyertakan informasi lain, tambahkan di sini
            ];
        });
    
        return $ruangsForCalendar;
    }    
}
