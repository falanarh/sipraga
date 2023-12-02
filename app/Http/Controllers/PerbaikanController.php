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
use Illuminate\Support\Facades\DB;
use Barryvdh\Snappy\Facades\SnappyImage as Snappy;
use Dompdf\Options;
use Clegginabox\PDFMerger\PDFMerger;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\File;

class PerbaikanController extends Controller
{

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            //'pengaduan_id' => 'required|exists:pengaduans,pengaduan_id',
            'tanggal_selesai' => 'required',
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
            'lampiran_perbaikan' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
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

    public function dataTeknisi()
    {
        $perbaikans = Perbaikan::join('pengaduans', 'perbaikans.pengaduan_id', '=', 'pengaduans.pengaduan_id')
            ->leftJoin('users', 'pengaduans.teknisi_id', '=', 'users.user_id')
            ->select('perbaikans.*', 'pengaduans.tiket', 'pengaduans.tanggal', 'pengaduans.jenis_barang', 'pengaduans.kode_ruang', 'users.name as teknisi_name')
            ->get();
        
        return Datatables::of($perbaikans)
            ->addColumn('action', function($perbaikans) {
                return '<a href="/teknisi/daftar-perbaikan/detail/'.$perbaikans->tiket.'" class="btn btn-dark">Detail</a>';
            })
            ->make(true);
    }

    public function dataKoordinator()
    {
        $perbaikans = Perbaikan::join('pengaduans', 'perbaikans.pengaduan_id', '=', 'pengaduans.pengaduan_id')
            ->leftJoin('users', 'pengaduans.teknisi_id', '=', 'users.user_id')
            ->select('perbaikans.*', 'pengaduans.tiket', 'pengaduans.tanggal', 'pengaduans.jenis_barang', 'pengaduans.kode_ruang', 'users.name as teknisi_name')
            ->get();
        
        return Datatables::of($perbaikans)
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

    // Get the absolute path to the PDF attachment
    $lampiranPath = storage_path('app/public/' . $perbaikan->lampiran_perbaikan);

    // Check if the attachment is a PDF
    if (pathinfo($perbaikan->lampiran_perbaikan, PATHINFO_EXTENSION) === 'pdf') {
        // Load the PDF content of export.perbaikan-print view
        $viewContent = view('export.perbaikan-print', compact('perbaikan'))->render();

        // Create a new Mpdf instance
        $mpdf = new Mpdf();

        // Write the view content to the PDF
        $mpdf->WriteHTML($viewContent);

        // Add the PDF attachment
        $mpdf->AddPage();
        $mpdf->Image($lampiranPath, 10, 10, 100, 100);

        // Save the PDF file
        $mergedPath = storage_path('app/public/merged/') . $perbaikan->tiket . '_merged.pdf';
        $mpdf->Output($mergedPath, 'F');

        // Output the merged PDF
        return response()->file($mergedPath);
    }

    // If it's not a PDF, proceed with the existing logic
    $dompdf = new Dompdf();
    $dompdf->loadHtml(view('export.perbaikan-print', compact('perbaikan', 'lampiranPath')));
    $dompdf->set_option('isHtml5ParserEnabled', true);
    $dompdf->set_option('isPhpEnabled', true);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    $filename = 'perbaikan-' . $perbaikan->tiket . '.pdf';

    return $dompdf->stream($filename, [
        'Attachment' => 1,
    ]);
}



//     public function printPerbaikan($tiket)
// {
//     // Fetch the Perbaikan data for the given $tiket
//     $perbaikan = Perbaikan::join('pengaduans', 'perbaikans.pengaduan_id', '=', 'pengaduans.pengaduan_id')
//         ->where('pengaduans.tiket', $tiket)
//         ->first();

//     if (!$perbaikan) {
//         return redirect()->back()->with('error', 'Perbaikan not found');
//     }

//     // Get the absolute path to the image file
//     $lampiranPath = public_path('storage/' . $perbaikan->lampiran_perbaikan);

//     // Check if the image file exists
//     if (!file_exists($lampiranPath)) {
//         return redirect()->back()->with('error', 'Bukti Perbaikan Image not found');
//     }

//     // Instantiate and use the dompdf class
//     $dompdf = new Dompdf();
//     $dompdf->loadHtml(view('export.perbaikan-print', compact('perbaikan', 'lampiranPath')));
//     $dompdf->set_option('isHtml5ParserEnabled', true);
//     $dompdf->set_option('isPhpEnabled', true);

//     // (Optional) Setup the paper size and orientation
//     $dompdf->setPaper('A4', 'portrait');

//     // Render the HTML as PDF
//     $dompdf->render();

//     // Set the file name
//     $filename = 'perbaikan-' . $perbaikan->tiket . '.pdf';

//     // Output the generated PDF to Browser with the specified filename
//     return $dompdf->stream($filename, [
//         'Attachment' => 1, // 0: Inline, 1: Attachment (download)
//     ]);
// }

    

}

