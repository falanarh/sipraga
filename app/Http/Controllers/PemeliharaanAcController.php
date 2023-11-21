<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PemeliharaanAc;
use App\Models\JadwalPemeliharaanAc;
use App\Rules\NotTomorrow;

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
            'lampiran' => 'nullable|file|mimes:pdf|max:2048',
        ], [
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi!',
            'tanggal_masuk.date' => 'Format Tanggal Masuk tidak valid!',
            'judul_pemeliharaan.required' => 'Judul pemeliharaan wajib diisi!',
            'judul_pemeliharaan.string' => 'Judul pemeliharaan harus berupa string!',
            'judul_pemeliharaan.max' => 'Judul pemeliharaan tidak boleh melebihi 255 karakter!',
            'judul_perbaikan.required' => 'Judul perbaikan wajib diisi!',
            'judul_perbaikan.string' => 'Judul perbaikan harus berupa string!',
            'judul_perbaikan.max' => 'Judul perbaikan tidak boleh melebihi 255 karakter!',
            'keterangan.required' => 'Keterangan tidak boleh kosong!',
            'lampiran.file' => 'Lampiran harus berupa file!',
            'lampiran.mimes' => 'Lampiran harus berupa file PDF atau JPG!',
            'lampiran.max' => 'Lampiran tidak boleh melebihi 2MB!',
        ]);

        // Menghitung jumlah baris data yang sudah ada
        $jumlahBarisData = PemeliharaanAc::count();

        // Menambahkan kolom nomor
        $request->merge(['nomor' => $jumlahBarisData + 1]);

        // Menyimpan data baru ke dalam tabel
        PemeliharaanAc::create($request->all());

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
