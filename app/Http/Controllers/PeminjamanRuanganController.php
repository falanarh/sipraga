<?php

namespace App\Http\Controllers;

use App\Models\Ruang;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\PeminjamanRuangan;
use Illuminate\Routing\Controller;
use App\Http\Requests\StorePeminjamanRuanganRequest;
use App\Http\Requests\UpdatePeminjamanRuanganRequest;


class PeminjamanRuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StorePeminjamanRuanganRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'kode_ruang' => ['required', 'string'],
                'peminjam' => ['required', 'string'],
                'keterangan' => ['required', 'string'],
                'status' => ['required', 'string'],
                'tanggapan' => ['nullable', 'string'],
                // 'waktu' => ['required', 'date_format:d/m/Y H:i'],
            ], [
                'kode_ruang.required' => 'Ruang wajib diisi!',
                'kode_ruang.string' => 'Ruang harus berupa string!',
                'peminjam.required' => 'Peminjam wajib diisi!',
                'peminjam.string' => 'Peminjam harus berupa string!',
                'keterangan.required' => 'Keterangan wajib diisi!',
                'keterangan.string' => 'Keterangan harus berupa string!',
                'status.required' => 'Status wajib diisi!',
                'status.string' => 'Status harus berupa string!',
                'tanggapan.string' => 'Tanggapan harus berupa string!',
                'waktu.required' => 'Waktu wajib diisi!',
                'waktu.date_format' => 'Format waktu tidak valid. Gunakan format dd/mm/yyyy H:i.',
            ]);

            // Menghitung jumlah baris data yang sudah ada
            $jumlahBarisData = PeminjamanRuangan::count();

            // Menambahkan kolom nomor
            $request->merge(['nomor' => $jumlahBarisData + 1]);
            $request->merge(['nomor' => $jumlahBarisData + 1]);

            // Menyimpan data baru ke dalam tabel
            PeminjamanRuangan::create($request->all());

            $response = [
                'success' => 'Peminjaman ruangan berhasil dibuat!'
            ];

            return response()->json($response, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            $response = [
                'error' => 'Terjadi kesalahan saat menyimpan data peminjaman ruangan.',
                'details' => $e->getMessage(),
            ];

            return response()->json($response, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
