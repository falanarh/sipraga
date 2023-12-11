<?php

// app/Imports/AsetImport.php

namespace App\Imports;

use App\Models\Aset;
use App\Models\Barang;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class AsetImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        // Cek apakah Barang sudah ada di database
        $barang = Barang::find($row['kode_barang']);

        if ($barang) {
            // Cek apakah Aset sudah ada di database
            $aset = Aset::where('kode_barang', $row['kode_barang'])
                ->where('nup', $row['nup'])
                ->first();

            if (!$aset) {
                // Jika Aset belum ada maka tambahkan aset
                // Membuat Aset baru dan mengaitkannya dengan Barang yang sudah ada
                return new Aset([
                    'kode_barang' => $row['kode_barang'],
                    'nup' => $row['nup'],
                    'nomor' => Aset::count() + 1,
                    'merek' => $row['merek'],
                    'tanggal_masuk' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tgl_perolehan']),
                    'kondisi' => $row['kondisi'],
                ]);
            }
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
