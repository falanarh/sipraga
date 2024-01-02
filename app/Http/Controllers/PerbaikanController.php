<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Pengaduan;
use App\Models\Perbaikan;
use Barryvdh\DomPDF\PDF;
use App\Rules\NotTomorrow;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Barang;
use App\Models\Ruang;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Dompdf\Options;
use Clegginabox\PDFMerger\PDFMerger;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\File;
use Barryvdh\Snappy\Facades\SnappyImage as SnappyImage;

class PerbaikanController extends Controller
{

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            //'pengaduan_id' => 'required|exists:pengaduans,pengaduan_id',
            'tanggal_selesai' => ['required', 'date', new NotTomorrow],
            'kode_barang' => 'required',
            'nup' => 'required',
            'perbaikan' => 'required',
            'keterangan' => 'required',
            'lampiran_perbaikan' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        // Retrieve $tiket from the route parameters
        $tiket = $request->route('tiket');
        
        $pengaduan = Pengaduan::where('tiket', $tiket)->first();
        // $jenisBarang = $pengaduan->jenis_barang;
        
        // // Adjust the way you retrieve kode_barang based on the relationship between Pengaduan and Barang
        // $kodeBarang = Barang::where('jenis_barang', $jenisBarang)->where('kode_barang', $request->input('kode_barang'))->firstOrFail();
        
        // // Adjust the way you retrieve nup based on the relationship between Barang and Aset
        // $nup = Aset::where('kode_barang', $kodeBarang->kode_barang)->where('nup', $request->input('nup'))->firstOrFail();
        
        // Store the uploaded file with a custom name
        $lampiranName = $tiket . '.' . $request->file('lampiran_perbaikan')->getClientOriginalExtension();
        $lampiranPerbaikanPath = $request->file('lampiran_perbaikan')->storeAs('lampiran_perbaikan', $lampiranName, 'public');
        
        Perbaikan::create([
            'pengaduan_id' => $pengaduan->pengaduan_id,
            'tanggal_selesai' => $request->input('tanggal_selesai'),
            'kode_barang' => $request->input('kode_barang'),
            'nup' =>  $request->input('nup'),
            'perbaikan' => $request->input('perbaikan'),
            'keterangan' => $request->input('keterangan'),
            'lampiran_perbaikan' => $lampiranPerbaikanPath,
        ]);

        // Update status in Pengaduan table
        $pengaduan->update([
            'status' => 'Selesai',
        ]);
        
        return redirect()->route('teknisi.daftar-perbaikan')->with('success', 'Perbaikan created successfully');

    }


    public function update(Request $request, $tiket)
    {
        // Validate the request data
        $request->validate([
            'tanggal_selesai' => 'required',
            'kode_barang' => 'required',
            'nup' => 'required',
            'perbaikan' => 'required',
            'keterangan' => 'required',
            'lampiran_perbaikan' => 'file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);
        

        // Retrieve the Perbaikan record
        $perbaikan = Perbaikan::join('pengaduans', 'perbaikans.pengaduan_id', '=', 'pengaduans.pengaduan_id')
            ->where('pengaduans.tiket', $tiket)
            ->first();

        if (!$perbaikan) {
            return redirect()->back()->with('error', 'Perbaikan not found');
        }

        // Update the fields that are not disabled
        $perbaikan->tanggal_selesai = $request->input('tanggal_selesai');
        $perbaikan->kode_barang = $request->input('kode_barang');
        $perbaikan->nup = $request->input('nup');
        $perbaikan->perbaikan = $request->input('perbaikan');
        $perbaikan->keterangan = $request->input('keterangan');

        // Update the lampiran_perbaikan field if a new file is uploaded
        if ($request->hasFile('lampiran_perbaikan')) {
            // Store the new uploaded file with a custom name
            $lampiranName = $tiket . '.' . $request->file('lampiran_perbaikan')->getClientOriginalExtension();
            $lampiranPerbaikanPath = $request->file('lampiran_perbaikan')->storeAs('lampiran_perbaikan', $lampiranName, 'public');

            $perbaikan->lampiran_perbaikan = $lampiranPerbaikanPath;
        }

        // Save the changes to the Perbaikan record
        $perbaikan->save();

        return redirect()->route('teknisi.daftar-perbaikan')->with('success', 'Perbaikan updated successfully');
    }

    // public function dataTeknisi(Request $request)
    // {
    //     $perbaikans = Perbaikan::with(['pengaduan']);

    //     // Filter data berdasarkan inputan user
    //     if ($request->filter_ruang != null) {
    //         $perbaikans->where('pengaduans.kode_ruang', $request->filter_ruang);}

    //     // Handle sorting based on the request
    //     if ($request->has('order')) {
    //         $order = $request->order[0];
    //         $columnIndex = $order['column'];
    //         $columnName = $request->columns[$columnIndex]['name'];
    //         $sortDirection = $order['dir'];
            
    //         // Handle sorting for jenis_barang and kode_ruang
    //     if ($columnName == 'jenis_barang') {
    //         leftJoin('pengaduans', 'perbaikans.' . $columnName, '=', 'pengaduans.jenis_barang')
    //                 ->select('perbaikans.*', 'pengaduans.jenis_barang');
    //         $perbaikans->orderBy('pengaduans.jenis_barang', $sortDirection);
    //     } else if ($columnName == 'kode_ruang') {
    //         $perbaikans->orderBy('pengaduan.kode_ruang', $sortDirection);
    //     }
    //     }

    //     return Datatables::of($perbaikans)
    //     ->addColumn('jenis_barang', function($perbaikans) {
    //         return $perbaikans->pengaduan->jenis_barang;
    //     })
    //     ->addColumn('kode_ruang', function($perbaikans) {
    //         return $perbaikans->pengaduan->kode_ruang;
    //     })
    //         ->addColumn('action', function($perbaikans) {
    //             return '<a href="/teknisi/daftar-perbaikan/detail/'.$perbaikans->tiket.'" class="btn btn-dark">Detail</a>';
    //         })
    //         ->make(true);
    // }

    public function dataTeknisi(Request $request)
    {
        $perbaikans = Perbaikan::join('pengaduans', 'perbaikans.pengaduan_id', '=', 'pengaduans.pengaduan_id')
            ->leftJoin('users', 'pengaduans.teknisi_id', '=', 'users.user_id')
            ->leftJoin('ruangs', 'pengaduans.kode_ruang', '=', 'ruangs.kode_ruang')
            ->select('perbaikans.*', 
            'pengaduans.tiket', 
            'pengaduans.tanggal', 
            'pengaduans.jenis_barang', 
            'ruangs.nama as nama_ruang',
            'pengaduans.kode_ruang', 
            'users.name as teknisi_name')
            ->where('pengaduans.teknisi_id', Auth::id());

        // Filter data berdasarkan inputan user
        if ($request->filter_ruang != null) {
            $perbaikans->where('ruangs.kode_ruang', $request->filter_ruang);}

        // Handle sorting based on the request
        if ($request->has('order')) {
            $order = $request->order[0];
            $columnIndex = $order['column'];
            $columnName = $request->columns[$columnIndex]['name'];
            $sortDirection = $order['dir'];

            // Sorting untuk ruang
            if ($columnName == 'nama_ruang') {
                $perbaikans->orderBy('ruangs.nama', $sortDirection);
            } else {
                $perbaikans->orderBy($columnName, $sortDirection);
            }
            
        }

        return Datatables::of($perbaikans)
            ->addColumn('tiket', function($perbaikans) {
                return $perbaikans->pengaduan->tiket;
            })
            ->addColumn('jenis_barang', function($perbaikans) {
                return $perbaikans->pengaduan->jenis_barang;
            })
            ->addColumn('kode_ruang', function($perbaikans) {
                $kodeRuang = $perbaikans->pengaduan->kode_ruang;
            
                // Fetch the room name from the 'ruangs' table
                $namaRuang = Ruang::where('kode_ruang', $kodeRuang)->value('nama');
            
                return $namaRuang;
            })
            ->addColumn('action', function($perbaikans) {
                return '<a href="/teknisi/daftar-perbaikan/detail/'.$perbaikans->tiket.'" class="btn btn-dark">Detail</a>';
            })
            ->make(true);
    }



    // public function dataKoordinator(Request $request)
    // {
    //     $perbaikans = Perbaikan::join('pengaduans', 'perbaikans.pengaduan_id', '=', 'pengaduans.pengaduan_id')
    //         ->leftJoin('users', 'pengaduans.teknisi_id', '=', 'users.user_id')
    //         ->leftJoin('ruangs', 'pengaduans.kode_ruang', '=', 'ruangs.kode_ruang')
    //         ->select('perbaikans.*', 'pengaduans.tiket', 'pengaduans.tanggal','ruangs.nama as nama_ruang', 'pengaduans.jenis_barang', 'pengaduans.kode_ruang', 'users.name as teknisi_name');
        
    //     // Filter data berdasarkan inputan user
    //     if ($request->filter_ruang != null) {
    //         $perbaikans->where('ruangs.kode_ruang', $request->filter_ruang);}

    //     // Handle sorting based on the request
    //     if ($request->has('order')) {
    //         $order = $request->order[0];
    //         $columnIndex = $order['column'];
    //         $columnName = $request->columns[$columnIndex]['name'];
    //         $sortDirection = $order['dir'];

    //         // Sorting untuk ruang
    //         if ($columnName == 'nama_ruang') {
    //             $perbaikans->orderBy('ruangs.nama', $sortDirection);
    //         } else {
    //             $perbaikans->orderBy($columnName, $sortDirection);
    //         }
            
    //     }

    //     return Datatables::of($perbaikans)
    //         ->addColumn('action', function($perbaikans) {
    //             return '<a href="/koordinator/daftar-perbaikan/detail/'.$perbaikans->tiket.'" class="btn btn-dark">Detail</a>';
    //         })
    //         ->make(true);
    // }

    public function dataKoordinator(Request $request)
    {
        $perbaikans = Perbaikan::join('pengaduans', 'perbaikans.pengaduan_id', '=', 'pengaduans.pengaduan_id')
            ->leftJoin('users', 'pengaduans.teknisi_id', '=', 'users.user_id')
            ->leftJoin('ruangs', 'pengaduans.kode_ruang', '=', 'ruangs.kode_ruang')
            ->select('perbaikans.*', 'pengaduans.tiket', 'pengaduans.tanggal','ruangs.nama as nama_ruang', 'pengaduans.jenis_barang', 'pengaduans.kode_ruang', 'users.name as teknisi_name');
        
        // Filter data berdasarkan inputan user
        if ($request->filter_ruang != null) {
            $perbaikans->where('ruangs.kode_ruang', $request->filter_ruang);}

        // Handle sorting based on the request
        if ($request->has('order')) {
            $order = $request->order[0];
            $columnIndex = $order['column'];
            $columnName = $request->columns[$columnIndex]['name'];
            $sortDirection = $order['dir'];

            // Sorting untuk ruang
            if ($columnName == 'nama_ruang') {
                $perbaikans->orderBy('ruangs.nama', $sortDirection);
            } else {
                $perbaikans->orderBy($columnName, $sortDirection);
            }
            
        }

        return Datatables::of($perbaikans)
            ->addColumn('tiket', function($perbaikans) {
                return $perbaikans->pengaduan->tiket;
            })
            ->addColumn('jenis_barang', function($perbaikans) {
                return $perbaikans->pengaduan->jenis_barang;
            })
            ->addColumn('kode_ruang', function($perbaikans) {
                $kodeRuang = $perbaikans->pengaduan->kode_ruang;
            
                // Fetch the room name from the 'ruangs' table
                $namaRuang = Ruang::where('kode_ruang', $kodeRuang)->value('nama');
            
                return $namaRuang;
            })
            
            ->addColumn('teknisi_name', function($perbaikans) {
                $teknisiId = $perbaikans->pengaduan->teknisi_id;
            
                // Fetch the technician's name from the 'users' table
                $teknisiName = User::where('user_id', $teknisiId)->value('name');
            
                return $teknisiName;
            })
            
            ->addColumn('action', function($perbaikans) {
                return '<a href="/koordinator/daftar-perbaikan/detail/'.$perbaikans->tiket.'" class="btn btn-dark">Detail</a>';
            })
            ->make(true);
    }

    public function printPerbaikan($tiket)
{
    // Fetch the Perbaikan data for the given $tiket
    $perbaikan = Perbaikan::join('pengaduans', 'perbaikans.pengaduan_id', '=', 'pengaduans.pengaduan_id')
        ->where('pengaduans.tiket', $tiket)
        ->first();

    if (!$perbaikan) {
        return redirect()->back()->with('error', 'Perbaikan not found');
    }

    // Determine the file type based on the extension
    $lampiranFiles = explode(',', $perbaikan->lampiran_perbaikan);
    $firstFile = public_path('storage/' . trim($lampiranFiles[0]));

    // Check if the file is a PDF
    if (File::extension($firstFile) === 'pdf') {
        return $this->printPerbaikanPdf($tiket);
    }

    // Otherwise, assume it's an image
    return $this->printPerbaikanImage($tiket);
}
 
    public function printPerbaikanImage($tiket)
{
    // Fetch the Perbaikan data for the given $tiket
    $perbaikan = Perbaikan::join('pengaduans', 'perbaikans.pengaduan_id', '=', 'pengaduans.pengaduan_id')
        ->where('pengaduans.tiket', $tiket)
        ->first();

    if (!$perbaikan) {
        return redirect()->back()->with('error', 'Perbaikan not found');
    }

    // Get the absolute path to the image file
    $lampiranPath = public_path('storage/' . $perbaikan->lampiran_perbaikan);

    // Check if the image file exists
    if (!file_exists($lampiranPath)) {
        return redirect()->back()->with('error', 'Bukti Perbaikan Image not found');
    }

    // Instantiate and use the dompdf class
    $dompdf = new Dompdf();
    $dompdf->loadHtml(view('export.perbaikan-print', compact('perbaikan', 'lampiranPath')));
    $dompdf->set_option('isHtml5ParserEnabled', true);
    $dompdf->set_option('isPhpEnabled', true);

    // (Optional) Setup the paper size and orientation
    $dompdf->setPaper('A4', 'portrait');

    // Render the HTML as PDF
    $dompdf->render();

    // Set the file name
    $filename = 'perbaikan-' . $perbaikan->tiket . '.pdf';

    // Output the generated PDF to Browser with the specified filename
    return $dompdf->stream($filename, [
        'Attachment' => 1, // 0: Inline, 1: Attachment (download)
    ]);
}

// public function printPerbaikan($tiket)
// {
//     // Fetch the Perbaikan data for the given $tiket
//     $perbaikan = Perbaikan::join('pengaduans', 'perbaikans.pengaduan_id', '=', 'pengaduans.pengaduan_id')
//         ->where('pengaduans.tiket', $tiket)
//         ->first();

//     if (!$perbaikan) {
//         return redirect()->back()->with('error', 'Perbaikan not found');
//     }

//     // Instantiate and use the dompdf class
//     $options = new Options();
//     $options->set('isHtml5ParserEnabled', true);
//     $options->set('isPhpEnabled', true);

//     $dompdf = new Dompdf($options);

//     // Pass both the Perbaikan data to the view
//     $dompdf->loadHtml(view('export.perbaikan-print', compact('perbaikan')));

//     // (Optional) Setup the paper size and orientation
//     $dompdf->setPaper('A4', 'portrait');

//     // Render the HTML as PDF
//     $dompdf->render();

//     /** @var \Dompdf\Cpdf $cpdf */
//     $cpdf = $dompdf->getCanvas()->get_cpdf();

//     // Loop through each file in the "lampiran_perbaikan" field and embed them
//     $lampiranFiles = explode(',', $perbaikan->lampiran_perbaikan);
//     foreach ($lampiranFiles as $lampiranPath) {
//         $lampiranPath = public_path('storage/' . trim($lampiranPath));

//         if (file_exists($lampiranPath)) {
//             $cpdf->addEmbeddedFile(
//                 $lampiranPath,
//                 basename($lampiranPath),
//                 'Embedded File'
//             );
//         }
//     }

//     // Set the file name
//     $filename = 'perbaikan-' . $perbaikan->tiket . '.pdf';

//     // Output the generated PDF to Browser with the specified filename
//     return $dompdf->stream($filename, [
//         'Attachment' => 1, // 0: Inline, 1: Attachment (download)
//     ]);
// }

public function printPerbaikanPdf($tiket)
{
    // Fetch the Perbaikan data for the given $tiket
    $perbaikan = Perbaikan::join('pengaduans', 'perbaikans.pengaduan_id', '=', 'pengaduans.pengaduan_id')
        ->where('pengaduans.tiket', $tiket)
        ->first();

    if (!$perbaikan) {
        return redirect()->back()->with('error', 'Perbaikan not found');
    }

    // Instantiate and use the dompdf class
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isPhpEnabled', true);

    $dompdf = new Dompdf($options);

    // Pass both the Perbaikan data to the view
    $dompdf->loadHtml(view('export.perbaikan-print-pdf', compact('perbaikan')));

    // (Optional) Setup the paper size and orientation
    $dompdf->setPaper('A4', 'portrait');

    // Render the HTML as PDF
    $dompdf->render();

    // Get the output of the Dompdf
    $dompdfOutput = $dompdf->output();

    // Save the Dompdf output to a temporary file
    $tempPdfFile = tempnam(sys_get_temp_dir(), 'dompdf');
    file_put_contents($tempPdfFile, $dompdfOutput);

    // Merge Dompdf output with additional PDFs using PDFMerger
    $pdfMerger = new PDFMerger();
    $pdfMerger->addPDF($tempPdfFile, 'all');

    // Loop through each file in the "lampiran_perbaikan" field and add them to the merger
    $lampiranFiles = explode(',', $perbaikan->lampiran_perbaikan);
    foreach ($lampiranFiles as $lampiranPath) {
        $lampiranPath = public_path('storage/' . trim($lampiranPath));

        if (file_exists($lampiranPath)) {
            $pdfMerger->addPDF($lampiranPath, 'all');
        }
    }

    // Output the merged PDF to Browser with the specified filename
    $filename = 'perbaikan-' . $perbaikan->tiket . '.pdf';
    $pdfMerger->merge('browser', $filename);
}


}