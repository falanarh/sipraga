<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\RuangImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ImportRuangController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ], [
            'file.required' => 'File tidak boleh kosong!',
            'file.mimes' => 'Format file harus xlsx atau xls!',
        ]);

        $file = $request->file('file');

        // Import data dari file Excel
        Excel::import(new RuangImport, $file);

        return redirect()->route('admin.data-ruangan')->with('success', 'Data Ruang berhasil diimpor!');
    }
}


// <?php

// namespace App\Http\Controllers;

// use App\Imports\AsetImport;
// use Illuminate\Http\Request;
// use App\Http\Controllers\Controller;
// use Maatwebsite\Excel\Facades\Excel;

// class ImportAsetController extends Controller
// {
//     public function import(Request $request)
//     {
//         $request->validate([
//             'file' => 'required|mimes:xlsx,xls',
//         ], [
//             'file.required' => 'File tidak boleh kosong!',
//             'file.mimes' => 'Format file harus xlsx atau xls!',
//         ]);

//         $file = $request->file('file');

//         // Import data dari file Excel
//         Excel::import(new AsetImport, $file);

//         return redirect()->route('admin.data-master')->with('success', 'Data Aset berhasil diimpor!');
//     }
// }
