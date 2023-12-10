<?php

namespace App\Http\Controllers;

use DateTime;
use Exception;
use DatePeriod;
use DateInterval;
use App\Models\Ruang;
use Illuminate\Http\Request;
use App\Helpers\TimeFormatter;
use App\Models\PeminjamanRuangan;
use Google\Client as Google_Client;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Google\Service\Drive as Google_Service_Drive;
use Google\Service\Exception as Google_Exception;
use Google\Service\Sheets as Google_Service_Sheets;
use Google\Service\Sheets\Request as Google_Service_Sheets_Request;
use Google\Service\Sheets\RowData as Google_Service_Sheets_RowData;
use Google\Service\Sheets\CellData as Google_Service_Sheets_CellData;
use Google\Service\Sheets\BatchUpdateSpreadsheetRequest as Google_Service_Sheets_BatchUpdateSpreadsheetRequest;


class GoogleSheetController extends Controller
{
    // public function getKetersediaanRuangs(Request $req)
    // {
    //     try {
    //         $timeFormatter = new TimeFormatter();

    //         // Ekstrak komponen tanggal dari request
    //         $startDate = $req->startDate;
    //         $endDate = $req->endDate;

    //         // Tentukan waktu awal dan waktu akhir dari rentang waktu
    //         $startTime = $req->startTime;
    //         $endTime = $req->endTime;

    //         // Inisialisasi array untuk menyimpan data ketersediaan ruangan
    //         $ketersediaanRuangs = [];

    //         // Iterasi untuk setiap tanggal dalam rentang waktu
    //         $currentDate = $startDate;
    //         while ($currentDate <= $endDate) {
    //             // Format tanggal ke format yang diinginkan (d-m-Y)
    //             $formattedDate = $timeFormatter->formatDateDMY($currentDate);

    //             // Panggil fungsi getKetersediaanRuangsPerTanggal untuk mendapatkan data ketersediaan ruangan pada tanggal tersebut
    //             $response = $this->getKetersediaanRuangsPerTanggal($formattedDate, $startTime . '-' . $endTime);

    //             // Tambahkan data ketersediaan ruangan ke dalam array utama
    //             $ketersediaanRuangs[$formattedDate] = $response['data'];

    //             // Pindahkan ke tanggal berikutnya
    //             $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
    //         }

    //         $response = [
    //             'status_code' => 200,
    //             'message' => 'Berhasil mendapatkan data ketersediaan ruangan!',
    //             'data' => $ketersediaanRuangs,
    //         ];

    //         return response()->json($response, 200);
    //     } catch (Exception $e) {
    //         $response = [
    //             'status_code' => 500,
    //             'error' => $e->getMessage(),
    //         ];

    //         return response()->json($response, 500);
    //     }
    // }

    // 

    public function getKetersediaanRuangs(Request $req)
    {
        try {

            // Validasi input
            $validator = Validator::make($req->all(), [
                'startDate' => 'required|date',
                'endDate' => 'required|date|after_or_equal:startDate',
                'startTime' => 'required|date_format:H:i',
                'endTime' => 'required|date_format:H:i|after:startTime',
            ]);

            // Cek apakah validasi gagal
            if ($validator->fails()) {
                $response = [
                    'status_code' => 400,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()->first(),
                ];

                return response()->json($response, 400);
            }

            $startDate = new DateTime($req->startDate);
            $endDate = new DateTime($req->endDate);
            $startTime = $req->startTime;
            $endTime = $req->endTime;

            $param_kode_ruangs = Ruang::select('kode_ruang')->get();

            $matriksRuangs = [];
            // Mengambil seluruh data kode ruang
            $kode_ruangs = Ruang::pluck('kode_ruang');

            // Iterasi sebanyak hari dalam rentang tanggal
            for ($currentDate = $startDate; $currentDate <= $endDate; $currentDate->modify('+1 day')) {
                // Mendapatkan data JSON dari suatu sumber, misalnya, metode getKetersediaanRuangsPerTanggal
                $json_data = $this->getKetersediaanRuangsPerTanggal($currentDate->format('d-m-Y'), $startTime . '-' . $endTime, $param_kode_ruangs);

                // Mengonversi JSON ke array asosiatif
                $res = json_decode($json_data->getContent(), true);

                $data = $res['data'];

                // Menggunakan format tanggal sebagai kunci array
                $currentDateString = $currentDate->format('d-m-Y');

                foreach ($kode_ruangs as $kode_ruang) {
                    $matriksRuangs[$currentDateString][$kode_ruang]['availability'] = $data[$kode_ruang]['availability'];
                }

                $ketersediaanRuangs = [];

                // Iterasi melalui tanggal-tanggal
                foreach ($matriksRuangs as $tanggal => $ruangs) {
                    // Iterasi melalui ruang-ruang pada setiap tanggal
                    foreach ($ruangs as $kode_ruang => $data) {
                        // Inisialisasi status ruang
                        $ruangTersedia = true;

                        // Cek semua tanggal untuk ruang tersebut
                        foreach ($matriksRuangs as $tgl => $ruangsTgl) {
                            if ($ruangsTgl[$kode_ruang]['availability'] !== 'Tersedia') {
                                // Jika salah satu tanggal tidak tersedia, set status ruang menjadi false dan keluar dari loop
                                $ruangTersedia = false;
                                break;
                            }
                        }

                        // Set nilai status ruang pada tanggal tersebut
                        if ($ruangTersedia) {
                            $ketersediaanRuangs[$kode_ruang]['availability'] = 'Tersedia';
                        } else {
                            $ketersediaanRuangs[$kode_ruang]['availability'] = 'Tidak Tersedia';
                        }
                    }
                }
            }

            $response = [
                'status_code' => 200,
                'message' => 'Berhasil mendapatkan data ketersediaan ruangan!',
                'data' => $ketersediaanRuangs,
            ];

            return response()->json($response, 200);
        } catch (\Exception $e) {
            // Tangkap dan tangani kesalahan
            $response = [
                'status_code' => 500,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                'data' => null,
            ];

            return response()->json($response, 500);
        }
    }



    // try {
    //     // $timeFormatter = new TimeFormatter();

    //     // // Ekstrak komponen tanggal dari request
    //     // $startDate = $req->startDate;
    //     // $endDate = $req->endDate;

    //     // // Tentukan waktu awal dan waktu akhir dari rentang waktu
    //     // $startTime = $req->startTime;
    //     // $endTime = $req->endTime;
    // } catch (Exception $e) {
    //     $response = [
    //         'status_code' => 500,
    //         'error' => $e->getMessage(),
    //     ];

    //     return response()->json($response, 500);
    // }


    public function getKetersediaanRuangsPerTanggal($hariBulanTahun, $waktu, $kode_ruangs)
    {
        try {
            $timeFormatter = new TimeFormatter();
            $date = $timeFormatter->extractDateComponents($hariBulanTahun);
            $time = $timeFormatter->parseTimeRange($waktu); //start time: $time['start'], end time: $time['end']

            $spreadsheetId = '1Jnid2YGJLwNopjjAtK83s-DJPK_nAAvyIHgMK693y_A';
            $sheetName = $date['monthName'] . ' ' . $date['year'];
            $range = $sheetName . '!C4:AG55';

            $client = new Google_Client();
            $client->setAuthConfig('client.json');
            $client->setAccessType('offline');
            $client->setScopes([Google_Service_Sheets::SPREADSHEETS]);
            $service = new Google_Service_Sheets($client);

            try {
                // Mendapatkan data dari Google Sheet
                $response = $service->spreadsheets->get($spreadsheetId, ['ranges' => $range, 'includeGridData' => true]);
            } catch (Google_Exception $e) {
                // Tangani eksepsi dari Google Sheets API
                $status_code = $e->getCode();

                if ($status_code === 404 || $status_code === 400) {
                    // Sheet not found, lempar eksepsi
                    $response = [
                        'status_code' => $status_code,
                        'error' => 'Tidak dapat mengecek ruangan pada bulan ' . $sheetName . '!',
                    ];

                    return response()->json($response, $status_code);
                } else {
                    // Eksepsi lain dari Google Sheets API
                    $response = [
                        'status_code' => $status_code,
                        'error' => $e->getMessage(),
                    ];

                    return response()->json($response, $status_code);
                }
            } catch (Exception $e) {
                // Tangani eksepsi lainnya
                $response = [
                    'status_code' => 500,
                    'error' => $e->getMessage(),
                ];

                return response()->json($response, 500);
            }

            $sheetData = $response->getSheets()[0]->getData()[0]->getRowData();

            // Get headers from the first row
            $headers = [];
            $firstRow = $sheetData[0]->getValues();
            foreach ($firstRow as $colIndex => $cell) {
                $headers[$colIndex] = $cell->getFormattedValue();
            }

            // Memproses data
            $data = [];

            foreach ($sheetData as $rowIndex => $row) {
                // Skip the first row
                if ($rowIndex === 0) {
                    continue;
                }

                $rowData = [];
                foreach ($row->getValues() as $colIndex => $cell) {
                    $column = $headers[$colIndex]; // Make sure $headers is defined and contains enough columns

                    // Menambahkan data ke dalam array
                    $schedule = $timeFormatter->extractTimeRangesFromString($cell->getNote());
                    $isAvailable = $timeFormatter->isTimeRangeAvailable($time, $schedule);

                    $rowData[$column] = [
                        'note' => $cell->getNote(),
                        'schedule' => $schedule,
                        'color' => $cell->getEffectiveFormat()->getBackgroundColor(),
                        'availability' => $isAvailable ? 'Tersedia' : 'Tidak Tersedia',
                    ];
                }

                // Menambahkan data ke dalam array utama dengan nama kode ruang sebagai kunci
                $data[$kode_ruangs[$rowIndex - 1]->kode_ruang] = $rowData;
            }

            $ruangs_pertanggal = [];
            for ($baris = 0; $baris < count($data); $baris++) {
                // Pastikan kode ruang pada indeks $baris tersedia
                if (isset($kode_ruangs[$baris])) {
                    $kode_ruang = $kode_ruangs[$baris]->kode_ruang;

                    // Pastikan data pada indeks $baris dan tanggal yang diinginkan tersedia
                    if (isset($data[$kode_ruang][(int)$date['day']])) {
                        // Ambil nilai schedule dan availability dari cell
                        $nilai_kolom = $data[$kode_ruang][(int)$date['day']];

                        // Tambahkan ke array hasil
                        $ruangs_pertanggal[$kode_ruang] = [
                            'schedule' => $nilai_kolom['schedule'],
                            'availability' => $nilai_kolom['availability'],
                        ];
                    }
                }
            }

            $response = [
                'status_code' => 200,
                'message' => 'Berhasil mendapatkan data ketersediaan ruangan!',
                'data' => $ruangs_pertanggal,
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

    public function setToUnavailable(Request $req)
    {
        try {
            // Validasi input
            $validator = Validator::make($req->all(), [
                'startDate' => 'required|date',
                'endDate' => 'required|date|after_or_equal:startDate',
                'startTime' => 'required|date_format:H:i',
                'endTime' => 'required|date_format:H:i|after:startTime',
                'kodeRuang' => 'required',
                'note' => 'required',
            ]);

            // Cek validasi
            if ($validator->fails()) {
                $response = [
                    'status_code' => 400,
                    'error' => 'Validasi gagal',
                    'message' => $validator->errors()->first(),
                ];

                return response()->json($response, 400);
            }

            // Lanjutkan dengan operasi jika validasi sukses
            $startDate = new DateTime($req->startDate);
            $endDate = new DateTime($req->endDate);
            $startTime = $req->startTime;
            $endTime = $req->endTime;
            $selectedRuang = $req->kodeRuang;
            $note = $req->note;
            $peminjam = $req->peminjam;
            $randomColor = $this->generateRandomColor();

            // Pengecekan apakah kode ruang ada dalam database
            $ruangExist = Ruang::where('kode_ruang', $selectedRuang)->exists();

            if (!$ruangExist) {
                $response = [
                    'status_code' => 404,
                    'message' => 'Kode ruang tidak ditemukan!',
                ];

                return response()->json($response, 404);
            }

            // Simpan data ke dalam database menggunakan Eloquent
            $peminjaman = new PeminjamanRuangan([
                'nomor' => PeminjamanRuangan::count() + 1,
                'tgl_mulai' => $startDate,
                'tgl_selesai' => $endDate,
                'waktu_mulai' => $startTime,
                'waktu_selesai' => $endTime,
                'kode_ruang' => $selectedRuang,
                'keterangan' => $note,
                'peminjam' => $peminjam
            ]);

            $peminjaman->save();

            for ($currentDate = $startDate; $currentDate <= $endDate; $currentDate->modify('+1 day')) {
                $this->setToUnavailablePerHari($currentDate->format('d-m-Y'), $startTime . '-' . $endTime, $selectedRuang, $note, $randomColor);
            }

            $response = [
                'status_code' => 200,
                'message' => 'Berhasil mengisi blok ruangan!',
            ];

            return response()->json($response, 200);
        } catch (\Exception $e) {
            $response = [
                'status_code' => 500,
                'error' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ];

            return response()->json($response, 500);
        }
    }



    public function setToUnavailablePerHari($hariBulanTahun, $waktu, $kode_ruang, $note, $randomColor)
    {
        try {
            $timeFormatter = new TimeFormatter();
            $date = $timeFormatter->extractDateComponents($hariBulanTahun);
            $time = $timeFormatter->parseTimeRange($waktu);

            $spreadsheetId = '1Jnid2YGJLwNopjjAtK83s-DJPK_nAAvyIHgMK693y_A';
            $sheetName = $date['monthName'] . ' ' . $date['year'];
            $range = $sheetName . '!C4:AG55';

            $client = new Google_Client();
            $client->setAuthConfig('client.json');
            $client->setAccessType('offline');
            $client->addScope(Google_Service_Sheets::SPREADSHEETS);
            $client->addScope(Google_Service_Drive::DRIVE);

            $service = new Google_Service_Sheets($client);

            // Retrieve the sheetId using the spreadsheetId and sheetName
            $spreadsheet = $service->spreadsheets->get($spreadsheetId);
            $sheets = $spreadsheet->getSheets();
            $sheetId = null;

            foreach ($sheets as $sheet) {
                if ($sheet->properties->title === $sheetName) {
                    $sheetId = $sheet->properties->sheetId;
                    break;
                }
            }

            if ($sheetId === null) {
                throw new Exception('Sheet not found');
            }

            $sortedRoomCodes = Ruang::orderBy('kode_ruang')->pluck('kode_ruang')->toArray();

            // Find the index of the user input code in the sorted array
            $roomIndex = $this->findRoomIndex($sortedRoomCodes, $kode_ruang);

            if ($roomIndex === -1) {
                throw new Exception('Ruang tidak ditemukan!');
            }

            // Generate a random background color
            // $randomColor = $this->generateRandomColor();

            // Prepare the update request
            $requests = [
                new Google_Service_Sheets_Request([
                    'updateCells' => [
                        'rows' => [
                            new Google_Service_Sheets_RowData([
                                'values' => [
                                    new Google_Service_Sheets_CellData([
                                        'note' => $note . ' ' . $time['start'] . '-' . $time['end'],
                                        'userEnteredFormat' => [
                                            'backgroundColor' => [
                                                'red' => hexdec(substr($randomColor, 1, 2)) / 255,
                                                'green' => hexdec(substr($randomColor, 3, 2)) / 255,
                                                'blue' => hexdec(substr($randomColor, 5, 2)) / 255,
                                            ],
                                        ],
                                    ]),
                                ],
                            ]),
                        ],
                        'fields' => 'note,userEnteredFormat.backgroundColor',
                        'range' => [
                            'sheetId' => $sheetId,
                            'startRowIndex' => $roomIndex + 5 - 1,
                            'endRowIndex' => $roomIndex + 5,
                            'startColumnIndex' => $date['day'] + 2 - 1,
                            'endColumnIndex' => $date['day'] + 2,
                        ],
                    ],
                ]),
            ];

            // Check if the cell already has a note
            $cell = $this->getExistingNoteAndBackgroundColor($service, $spreadsheetId, $sheetName, $roomIndex + 4, $date['day'] + 1);
            if (!$cell['note'] == '') {
                $twoCharacters = substr($cell['note'], 0, 2);

                if ($twoCharacters !== '- ') {
                    $requests[0]->updateCells->rows[0]->values[0]->note = "- " . $cell['note'] . "\n" . "- " . $requests[0]->updateCells->rows[0]->values[0]->note;
                } else {
                    $requests[0]->updateCells->rows[0]->values[0]->note = $cell['note'] . "\n" . "- " . $requests[0]->updateCells->rows[0]->values[0]->note;
                }
            }

            // Send the update request
            $batchUpdateRequest = new Google_Service_Sheets_BatchUpdateSpreadsheetRequest([
                'requests' => $requests,
            ]);
            $service->spreadsheets->batchUpdate($spreadsheetId, $batchUpdateRequest);

            $response = [
                'status_code' => 200,
                'message' => 'Cell updated successfully!',
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

    public function generateRandomColor()
    {
        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }

    public function findRoomIndex($sortedRoomCodes, $userInputCode)
    {
        // Use array_search to find the index of the user input code in the sorted array
        $index = array_search($userInputCode, $sortedRoomCodes);

        // array_search returns false if the element is not found
        // You can handle this accordingly in your application logic
        return $index !== false ? $index : -1;
    }

    // Function to get existing note from a cell
    private function getExistingNoteAndBackgroundColor($service, $spreadsheetId, $sheetId, $rowIndex, $columnIndex)
    {
        $response = $service->spreadsheets->get($spreadsheetId, ['ranges' => ($sheetId . '!R' . ($rowIndex + 1) . 'C' . ($columnIndex + 1)), 'includeGridData' => true]);
        // $response = $service->spreadsheets->get($spreadsheetId, ['ranges' => $range, 'includeGridData' => true]);
        // $cell = $response->getValues();
        $cell = $response->getSheets()[0]->getData()[0]->getRowData();

        // Mengambil nilai note
        $note = $cell[0]['values'][0]['note'];

        // Mengambil warna latar belakang
        $backgroundColor = $cell[0]['values'][0]['userEnteredFormat']['backgroundColor'];

        $data = [
            'note' => $note,
            'backgroundColor' => $backgroundColor,
        ];

        return $data;
    }
}





























// // Inisialisasi data ketersediaan ruang
// $ketersediaan_ruangs = [];

// // Iterasi untuk setiap kode ruang
// foreach ($kode_ruangs as $ruang) {
//     $kode_ruang = $ruang->kode_ruang;
//     $ketersediaan_per_tanggal = [];

//     // Iterasi untuk setiap tanggal
//     for ($tanggal = 1; $tanggal <= count($data[$kode_ruang]); $tanggal++) {
//         // Ambil data dari $data berdasarkan kode ruang dan tanggal
//         $data_ruang_tanggal = $data[$kode_ruang][$tanggal] ?? null;

//         // Tentukan status ketersediaan ruangan
//         $status = $data_ruang_tanggal ? $data_ruang_tanggal['availability'] : 'Tersedia';

//         // Simpan status ke dalam array
//         $ketersediaan_per_tanggal[$tanggal] = $status;
//     }

//     // Simpan array status ke dalam array utama
//     $ketersediaan_ruangs[$kode_ruang] = $ketersediaan_per_tanggal;
// }
