<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PemeliharaanAc;
use App\Models\JadwalPemeliharaanAc;
use App\Rules\NotTomorrow;
use Carbon\Carbon;
use Mpdf\Mpdf;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Aset;
use App\Models\Ruang;
use App\Models\Barang;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Clegginabox\PDFMerger\PDFMerger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\Snappy\Facades\SnappyImage as Snappy;



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
        $pemeliharaanAcData = $request->except('lampiran', 'nup');
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
            // $pemeliharaanAc->file_path = 'sipraga/'. $namaFile;
            $pemeliharaanAc->file_path = $lampiranPath;
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

    public function update(Request $request, $pemeliharaan_ac_id)
    {
        $request->validate([
            'tanggal_selesai' => ['required', 'date', new NotTomorrow], // Use the custom rule
            'judul_pemeliharaan' => 'required|string|max:255',
            'judul_perbaikan' => 'string|max:255',
            'keterangan' => 'required|string|max:255',
            // 'lampiran' => 'file|mimes:pdf,jpg,jpeg,jpg|max:2048',
        ], [
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi!',
            'judul_pemeliharaan.required' => 'Judul pemeliharaan wajib diisi!',
            'judul_pemeliharaan.string' => 'Judul pemeliharaan harus berupa string!',
            'judul_pemeliharaan.max' => 'Judul pemeliharaan tidak boleh melebihi 255 karakter!',
            'judul_perbaikan.string' => 'Judul perbaikan harus berupa string!',
            'judul_perbaikan.max' => 'Judul perbaikan tidak boleh melebihi 255 karakter!',
            'keterangan.required' => 'Keterangan tidak boleh kosong!',
            'keterangan.string' => 'Keterangan harus berupa string!',
            'keterangan.max' => 'Keterangan tidak boleh melebihi 255 karakter!',
            // 'lampiran.file' => 'Lampiran harus berupa file!',
            // 'lampiran.mimes' => 'Lampiran harus berupa file pdf, jpg, jpeg, atau png!',
            // 'lampiran.max' => 'Ukuran lampiran tidak boleh melebihi 2MB!',
        ]);


        // dd($request->lampiran);
        $pemeliharaanAc = PemeliharaanAc::find($pemeliharaan_ac_id);

        $pemeliharaanAc->tanggal_selesai = $request->tanggal_selesai;
        $pemeliharaanAc->judul_pemeliharaan = $request->judul_pemeliharaan;
        $pemeliharaanAc->judul_perbaikan = $request->judul_perbaikan;
        $pemeliharaanAc->keterangan = $request->keterangan;
        // $pemeliharaanAc->file_path = $request->file_path;

        // if ($request->hasFile('lampiran')) {
        //     $tanggalSelesai = Carbon::parse($request->tanggal_selesai);
        //     $namaFile = 'pemeliharaan/' . $tanggalSelesai->format('d-m-Y') . '/' . $request->nup;
        //     $ekstensiFile = $request->file('lampiran')->getClientOriginalExtension();
        //     $lampiranPath = $request->file('lampiran')->storeAs('sipraga', $namaFile . '.' . $ekstensiFile, 'public');

        //     $pemeliharaanAc->file_path = $lampiranPath;
        // }

        if ($request->hasFile('lampiran')) {
            // Jika ada file yang diunggah, simpan file baru
            $tanggalSelesai = Carbon::parse($request->tanggal_selesai);
            $namaFile = 'pemeliharaan/' . $tanggalSelesai->format('d-m-Y') . '/' . $request->nup;
            $ekstensiFile = $request->file('lampiran')->getClientOriginalExtension();
            $lampiranPath = $request->file('lampiran')->storeAs('sipraga/' . $namaFile, 'lampiran.' . $ekstensiFile, 'public');

            // Hapus file yang lama jika ada
            if ($pemeliharaanAc->file_path) {
                Storage::delete($pemeliharaanAc->file_path);
            }

            $pemeliharaanAc->file_path = $lampiranPath;
        } elseif (!$request->hasFile('lampiran') && !$pemeliharaanAc->file_path) {
            // Jika tidak ada file yang diunggah dan file_path sebelumnya NULL,
            // pertahankan nilai file_path
            $pemeliharaanAc->file_path = null;
        }

        $pemeliharaanAc->save();

        return redirect()->route('teknisi.daftar-pemeliharaan-detail', ['pemeliharaan_ac_id' => $pemeliharaan_ac_id])->with('success', 'Data pemeliharaan AC berhasil diupdate!');
    }

    public function data(Request $request)
    {

        $pemeliharaanAc = PemeliharaanAc::with(['jadwalPemeliharaanAc']);

        // Filter data berdasarkan inputan user
        if ($request->filled('filter_tanggal')) {
            $tanggalFilter = Carbon::createFromFormat('d/m/Y', $request->filter_tanggal)->format('Y-m-d');
            $pemeliharaanAc->whereDate('tanggal_selesai', $tanggalFilter);
        }
        if ($request->filter_kode_barang != null) {
            $pemeliharaanAc->whereHas('jadwalPemeliharaanAc', function ($query) use ($request) {
                $query->where('kode_barang', $request->filter_kode_barang);
            });
        }
        if ($request->filter_nup != null) {
            $pemeliharaanAc->whereHas('jadwalPemeliharaanAc', function ($query) use ($request) {
                $query->where('nup', 'like', $request->filter_nup);
            });
        }
        if ($request->filter_ruang != null) {
            $pemeliharaanAc->whereHas('jadwalPemeliharaanAc', function ($query) use ($request) {
                $query->whereHas('ruang', function ($query) use ($request) {
                    $query->where('nama', $request->filter_ruang);
                });
            });
        }


        return DataTables::of($pemeliharaanAc)
            ->addColumn('tanggal', function ($row) {
                return $row->tanggal_selesai->format('d/m/Y');
            })
            ->addColumn('kode_barang', function ($row) {
                return $row->jadwalPemeliharaanAc->kode_barang;
            })
            ->addColumn('nup', function ($row) {
                return $row->jadwalPemeliharaanAc->nup;
            })
            ->addColumn('ruang', function ($row) {
                return $row->jadwalPemeliharaanAc->ruang->nama;
            })
            ->addColumn('action', function ($row) {
                return '<a href="/teknisi/daftar-pemeliharaan/detail/' . $row->pemeliharaan_ac_id . '" class="btn btn-dark text-white align-items-center">Detail</a>';
            })
            // ->order(function ($query) use ($request) {
            //     if ($request->has('order')) {
            //         $order = $request->order[0];
            //         $columnIndex = $order['column'];
            //         $columnName = $request->columns[$columnIndex]['name'];
            //         $sortDirection = $order['dir'];

            //         if ($columnName == 'tanggal') {
            //             $query->orderBy('pemeliharaan_acs.tanggal_selesai', $sortDirection);
            //         } elseif ($columnName == 'kode_barang') {
            //             $query->orderBy('jadwal_pemeliharaan_acs.kode_barang', $sortDirection)
            //                 ->join('jadwal_pemeliharaan_acs', 'jadwal_pemeliharaan_acs.jadwal_pemeliharaan_ac_id', '=', 'pemeliharaan_acs.jadwal_pemeliharaan_ac_id');
            //         } elseif ($columnName == 'nup') {
            //             $query->orderBy('jadwal_pemeliharaan_acs.nup', $sortDirection)
            //                 ->join('jadwal_pemeliharaan_acs', 'jadwal_pemeliharaan_acs.jadwal_pemeliharaan_ac_id', '=', 'pemeliharaan_acs.jadwal_pemeliharaan_ac_id');
            //         } elseif ($columnName == 'ruang') {
            //             $query->orderBy('ruangs.nama', $sortDirection)
            //                 ->join('jadwal_pemeliharaan_acs', 'jadwal_pemeliharaan_acs.jadwal_pemeliharaan_ac_id', '=', 'pemeliharaan_acs.jadwal_pemeliharaan_ac_id')
            //                 ->join('ruangs', 'ruangs.id', '=', 'jadwal_pemeliharaan_acs.ruang_id');
            //         } else {
            //             $query->orderBy('pemeliharaan_acs.' . $columnName, $sortDirection);
            //         }
            //     }
            // })
            ->order(function ($query) use ($request) {
                if ($request->has('order')) {
                    $order = $request->order[0];
                    $columnIndex = $order['column'];
                    $columnName = $request->columns[$columnIndex]['name'];
                    $sortDirection = $order['dir'];

                    if ($columnName == 'tanggal') {
                        $query->orderBy('pemeliharaan_acs.tanggal_selesai', $sortDirection);
                    } elseif ($columnName == 'kode_barang') {
                        $query->orderBy('jadwal_pemeliharaan_acs.kode_barang', $sortDirection)
                            ->join('jadwal_pemeliharaan_acs', 'jadwal_pemeliharaan_acs.jadwal_pemeliharaan_ac_id', '=', 'pemeliharaan_acs.jadwal_pemeliharaan_ac_id');
                    } elseif ($columnName == 'nup') {
                        $query->orderBy('jadwal_pemeliharaan_acs.nup', $sortDirection)
                            ->join('jadwal_pemeliharaan_acs', 'jadwal_pemeliharaan_acs.jadwal_pemeliharaan_ac_id', '=', 'pemeliharaan_acs.jadwal_pemeliharaan_ac_id');
                    } elseif ($columnName == 'ruang') {
                        $query->orderBy('ruangs.nama', $sortDirection)
                            ->join('jadwal_pemeliharaan_acs', 'jadwal_pemeliharaan_acs.jadwal_pemeliharaan_ac_id', '=', 'pemeliharaan_acs.jadwal_pemeliharaan_ac_id')
                            ->join('ruangs', 'ruangs.kode_ruang', '=', 'jadwal_pemeliharaan_acs.kode_ruang');
                    } else {
                        $query->orderBy('pemeliharaan_acs.' . $columnName, $sortDirection);
                    }
                }
            })
            ->filterColumn('tanggal', function ($query, $keyword) {
                $query->whereDate('tanggal_selesai', 'like', '%' . $keyword . '%');
            })
            ->filterColumn('kode_barang', function ($query, $keyword) {
                $query->whereHas('jadwalPemeliharaanAc', function ($query) use ($keyword) {
                    $query->where('kode_barang', 'like', '%' . $keyword . '%');
                });
            })
            ->filterColumn('nup', function ($query, $keyword) {
                $query->whereHas('jadwalPemeliharaanAc', function ($query) use ($keyword) {
                    $query->where('nup', 'like', '%' . $keyword . '%');
                });
            })
            ->filterColumn('ruang', function ($query, $keyword) {
                $query->whereHas('jadwalPemeliharaanAc', function ($query) use ($keyword) {
                    $query->whereHas('ruang', function ($query) use ($keyword) {
                        $query->where('nama', 'like', '%' . $keyword . '%');
                    });
                });
            })

            ->rawColumns(['action'])
            ->make(true);
    }

    public function eksporPemeliharaan(Request $request)
    {
        $pemeliharaanAc = PemeliharaanAc::with(['jadwalPemeliharaanAc']);
        // $jadwalPemeliharaanAc = JadwalPemeliharaanAc::with(['ruang', 'user']);
        $created_at = \Carbon\Carbon::now()->setTimezone('Asia/Jakarta')->format('d/m/Y');

        // Mencari data pemeliharaan AC berdasarkan filter tanggal_selesai jika disertakan
        // if ($request->filled('filter_tanggal_selesai')) {
        //     $pemeliharaanAc->where('tanggal_selesai', $request->filter_tanggal_selesai);
        // }

        // Mendapatkan data pemeliharaan AC
        $dataPemeliharaan = $pemeliharaanAc->get();
        $dataAset = [];
        $no = 1;
        foreach ($dataPemeliharaan as $data) {
            $dataAset[$no] = Aset::where('kode_barang', $data->jadwalPemeliharaanAc->kode_barang)
                        ->where('nup', $data->jadwalPemeliharaanAc->nup)
                        ->first();
            $no++;
        }
        // $dataRuang = $jadwalPemeliharaanAc->get();

        // dd($dataAset);

        // Memeriksa apakah ada data pemeliharaan
        if ($dataPemeliharaan->isEmpty()) {
            // Jika tidak ada data pemeliharaan, kembalikan pesan kesalahan
            return redirect()->back()->with('error', 'Tidak ditemukan data pemeliharaan untuk tanggal ini!');
        }

        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('export.format-pemeliharaan', compact('dataPemeliharaan', 'created_at', 'dataAset')));

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Set the file name
        $filename = 'pemeliharaan-export.pdf';

        // Output the generated PDF to Browser with the specified filename
        return $dompdf->stream($filename, [
            'Attachment' => 1, // 0: Inline, 1: Attachment (download)
        ]);
    }

    // public function eksporPemeliharaanDetail(Request $request, $pemeliharaan_ac_id)
    // {
    //     // Find the PemeliharaanAc based on the provided $pemeliharaan_ac_id
    //     $pemeliharaanAc = PemeliharaanAc::with(['jadwalPemeliharaanAc'])->find($pemeliharaan_ac_id);

    //     $ac = Aset::where('kode_barang', $pemeliharaanAc->jadwalPemeliharaanAc->kode_barang)
    //                 ->where('nup', $pemeliharaanAc->jadwalPemeliharaanAc->nup)
    //                 ->first();

    //     // Check if the PemeliharaanAc is not found
    //     if (!$pemeliharaanAc) {
    //         return redirect()->back()->with('error', 'Data pemeliharaan tidak ditemukan!');
    //     }

    //     // Get the creation date in the specified timezone
    //     $created_at = \Carbon\Carbon::now()->setTimezone('Asia/Jakarta')->format('d/m/Y');

    //     // Access data from jadwalPemeliharaanAc
    //     $jadwalPemeliharaanAc = $pemeliharaanAc->jadwalPemeliharaanAc;

    //     // instantiate and use the dompdf class
    //     $dompdf = new Dompdf();
    //     $dompdf->loadHtml(view('export.format-pemeliharaan-detail', compact('pemeliharaanAc', 'created_at', 'jadwalPemeliharaanAc', 'ac')));

    //     // (Optional) Setup the paper size and orientation
    //     $dompdf->setPaper('A4', 'portrait');

    //     // Render the HTML as PDF
    //     $dompdf->render();

    //     // Set the file name
    //     $filename = 'pemeliharaan-detail-export.pdf';

    //     // Output the generated PDF to Browser with the specified filename
    //     return $dompdf->stream($filename, [
    //         'Attachment' => 1, // 0: Inline, 1: Attachment (download)
    //     ]);
    // }    
    public function eksporPemeliharaanDetail(Request $request, $pemeliharaan_ac_id)
    {
        // Find the PemeliharaanAc based on the provided $pemeliharaan_ac_id
        $pemeliharaanAc = PemeliharaanAc::with(['jadwalPemeliharaanAc'])->find($pemeliharaan_ac_id);

        // Check if the PemeliharaanAc is not found
        if (!$pemeliharaanAc) {
            return redirect()->back()->with('error', 'Data pemeliharaan tidak ditemukan!');
        }
    
        // Determine the file type based on the extension
        $lampiranFiles = explode(',', $pemeliharaanAc->file_path);
        $firstFile = public_path('storage/' . trim($lampiranFiles[0]));
    
        // Check if the file is a PDF
        if (File::extension($firstFile) === 'pdf') {
            return $this->printPemeliharaanPdf($pemeliharaan_ac_id);
        }
    
        // Otherwise, assume it's an image
        return $this->printPemeliharaanImage($pemeliharaan_ac_id);
    }

    public function printPemeliharaanImage($pemeliharaan_ac_id)
    {
        // Fetch the Perbaikan data for the given $tiket
        $pemeliharaanAc = PemeliharaanAc::with(['jadwalPemeliharaanAc'])->find($pemeliharaan_ac_id);

        $ac = Aset::where('kode_barang', $pemeliharaanAc->jadwalPemeliharaanAc->kode_barang)
                    ->where('nup', $pemeliharaanAc->jadwalPemeliharaanAc->nup)
                    ->first();

        // Check if the PemeliharaanAc is not found
        if (!$pemeliharaanAc) {
            return redirect()->back()->with('error', 'Data pemeliharaan tidak ditemukan!');
        }

        // Get the creation date in the specified timezone
        $created_at = \Carbon\Carbon::now()->setTimezone('Asia/Jakarta')->format('d/m/Y');

        // Access data from jadwalPemeliharaanAc
        $jadwalPemeliharaanAc = $pemeliharaanAc->jadwalPemeliharaanAc;
    
        // Get the absolute path to the image file
        $lampiranPath = public_path('storage/' . $pemeliharaanAc->file_path);
    
        // Check if the image file exists
        if (!file_exists($lampiranPath)) {
            return redirect()->back()->with('error', 'Bukti Pemeliharaan Image not found');
        }

        // Instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('export.format-pemeliharaan-detail', compact('pemeliharaanAc', 'created_at', 'jadwalPemeliharaanAc', 'ac', 'lampiranPath')));
        $dompdf->set_option('isHtml5ParserEnabled', true);
        $dompdf->set_option('isPhpEnabled', true);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Set the file name
        $filename = 'pemeliharaan-detail-export.pdf';

        // Output the generated PDF to Browser with the specified filename
        return $dompdf->stream($filename, [
            'Attachment' => 1, // 0: Inline, 1: Attachment (download)
        ]);
    }
    public function printPemeliharaanPdf($pemeliharaan_ac_id)
    {
        // Fetch the Perbaikan data for the given $tiket
        $pemeliharaanAc = PemeliharaanAc::with(['jadwalPemeliharaanAc'])->find($pemeliharaan_ac_id);

        $ac = Aset::where('kode_barang', $pemeliharaanAc->jadwalPemeliharaanAc->kode_barang)
                    ->where('nup', $pemeliharaanAc->jadwalPemeliharaanAc->nup)
                    ->first();

        // Check if the PemeliharaanAc is not found
        if (!$pemeliharaanAc) {
            return redirect()->back()->with('error', 'Data pemeliharaan tidak ditemukan!');
        }

        // Get the creation date in the specified timezone
        $created_at = \Carbon\Carbon::now()->setTimezone('Asia/Jakarta')->format('d/m/Y');

        // Access data from jadwalPemeliharaanAc
        $jadwalPemeliharaanAc = $pemeliharaanAc->jadwalPemeliharaanAc;

        // Instantiate and use the dompdf class
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        $dompdf = new Dompdf($options);

        // Pass both the Perbaikan data to the view
        $dompdf->loadHtml(view('export.format-pemeliharaan-detail-pdf', compact('pemeliharaanAc', 'created_at', 'jadwalPemeliharaanAc', 'ac')));

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
        $lampiranFiles = explode(',', $pemeliharaanAc->file_path);
        foreach ($lampiranFiles as $lampiranPath) {
            $lampiranPath = public_path('storage/' . trim($lampiranPath));

            if (file_exists($lampiranPath)) {
                $pdfMerger->addPDF($lampiranPath, 'all');
            }
        }

        // Output the merged PDF to Browser with the specified filename
        $filename = 'pemeliharaan-detail-pdf-export.pdf';
        $pdfMerger->merge('browser', $filename);
    }
}












