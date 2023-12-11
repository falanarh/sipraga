<?php

namespace App\Imports;

use App\Models\Ruang;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class RuangImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        // Cek apakah ruang dengan kode_ruang tertentu sudah ada
        $existingRuang = Ruang::where('kode_ruang', $row['kode_ruang'])->first();

        if(!$existingRuang){
            return new Ruang([
                'nomor' => Ruang::count() + 1,
                'kode_ruang' => $row['kode_ruang'],
                'nama' => $row['nama'],
                'gedung' => $row['gedung'],
                'lantai' => $row['lantai'],
                'kapasitas' => $row['kapasitas'],
            ]);
        }
    }

    public function rules(): array
    {
        return [
            // 'kode_barang' => 'required|string|exists:barangs,kode_barang',
            // 'nup' => 'required|string',
            // Sesuaikan aturan validasi sesuai kebutuhan
        ];
    }
}
