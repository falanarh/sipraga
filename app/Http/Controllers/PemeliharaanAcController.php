<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PemeliharaanAc;
use App\Models\JadwalPemeliharaanAc;
use App\Rules\NotTomorrow;
use Carbon\Carbon;

class PemeliharaanAcController extends Controller
{
    //
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'tanggal_selesai' => ['required', 'date', new NotTomorrow], // Use the custom rule
            'judul_pemeliharaan' => 'required|string|max:255',
            'judul_perbaikan' => 'required|string|max:255',
            'keterangan' => 'required|string|max:255',
            'lampiran' => 'file|mimes:pdf,jpg,jpeg,jpg|max:2048',
        ], [
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi!',
            'judul_pemeliharaan.required' => 'Judul pemeliharaan wajib diisi!',
            'judul_pemeliharaan.string' => 'Judul pemeliharaan harus berupa string!',
            'judul_pemeliharaan.max' => 'Judul pemeliharaan tidak boleh melebihi 255 karakter!',
            'judul_perbaikan.required' => 'Judul perbaikan wajib diisi!',
            'judul_perbaikan.string' => 'Judul perbaikan harus berupa string!',
            'judul_perbaikan.max' => 'Judul perbaikan tidak boleh melebihi 255 karakter!',
            'keterangan.required' => 'Keterangan tidak boleh kosong!',
            'keterangan.string' => 'Keterangan harus berupa string!',
            'keterangan.max' => 'Keterangan tidak boleh melebihi 255 karakter!',
            'lampiran.file' => 'Lampiran harus berupa file!',
            'lampiran.mimes' => 'Lampiran harus berupa file pdf, jpg, jpeg, atau png!',
            'lampiran.max' => 'Ukuran lampiran tidak boleh melebihi 2MB!',
        ]);

        // Menghitung jumlah baris data yang sudah ada
        $jumlahBarisData = PemeliharaanAc::count();

        // Menambahkan kolom nomor
        $request->merge(['nomor' => $jumlahBarisData + 1]);

        // Menyimpan data baru ke dalam tabel
        $pemeliharaanAcData = $request->except('lampiran','nup');
        $pemeliharaanAcData['file_path'] = null; // Inisialisasi dengan null
        $pemeliharaanAc = PemeliharaanAc::create($pemeliharaanAcData);

        // Menyimpan lampiran jika ada
        if ($request->hasFile('lampiran')) {
            // Menggunakan tanggal selesai dan NUP barang sebagai nama file tanpa ekstensi
            $tanggalSelesai = Carbon::parse($request->tanggal_selesai);
    
            // Menggunakan format d/m/Y pada nama file
            $namaFile = 'pemeliharaan/' . $tanggalSelesai->format('d-m-Y') . '/' . $request->nup;

            $ekstensiFile = $request->file('lampiran')->getClientOriginalExtension();
            
            // Menyimpan file dengan nama unik (termasuk ekstensi) di public storage
            $lampiranPath = $request->file('lampiran')->storeAs('sipraga', $namaFile . '.' . $ekstensiFile, 'public');
            
            // Menyimpan hanya nama file tanpa ekstensi di database
            $pemeliharaanAc->file_path = 'sipraga/'. $namaFile;
            $pemeliharaanAc->save();
        }

        // Mengupdate status jadwal pemeliharaan AC
        $jadwalPemeliharaanAc = JadwalPemeliharaanAc::find($request->jadwal_pemeliharaan_ac_id);
        $jadwalPemeliharaanAc->status = "Selesai Dikerjakan";
        $jadwalPemeliharaanAc->save();

        // Redirect dengan pesan sukses
        return redirect()
            ->route('teknisi.daftar-pemeliharaan') // Ganti dengan nama route yang sesuai
            ->with('success', 'Pemeliharaan AC berhasil ditambahkan');
    }

    public function data()
    {

    }
}
