<?php

namespace App\Http\Controllers;

use Google\Client as Google_Client;
use Google\Service\Sheets as Google_Service_Sheets;

class GoogleSheetController extends Controller
{
    public function readSheet()
    {
        $spreadsheetId = '1z7Bbc3i1g4kHpM_W30sNt9nJRbeDKcG8_b1Bz6weXyc';
        $sheetName = 'Agustus 23';
        $range = $sheetName . '!C5:AG55';

        $client = new Google_Client();
        $client->setDeveloperKey('AIzaSyCRnlZX-iVT4O8z0WfhmYvLTntowlAFPIE');
        $client->setScopes([Google_Service_Sheets::SPREADSHEETS]);
        $service = new Google_Service_Sheets($client);

        // Mendapatkan data dari Google Sheet
        $response = $service->spreadsheets->get($spreadsheetId, ['ranges' => $range, 'includeGridData' => true]);
        $sheetData = $response->getSheets()[0]->getData()[0]->getRowData();

        // Generate column headers dynamically (numbers from 1 to 31)
        $headers = array_map(function ($num) {
            return (string) $num;
        }, range(1, 31));

        // Memproses data
        $data = [];
        foreach ($sheetData as $rowIndex => $row) {
            $rowData = [];
            foreach ($row->getValues() as $colIndex => $cell) {
                $column = $headers[$colIndex]; // Make sure $headers is defined and contains enough columns

                // Menambahkan data ke dalam array
                $rowData[$column] = [
                    'data' => $cell->getFormattedValue(),
                    'note' => $cell->getNote(),
                    'color' => $cell->getEffectiveFormat()->getBackgroundColor(),
                ];
            }

            // Menambahkan data ke dalam array utama
            $data[] = $rowData;
        }

        return response()->json(['data' => $data]);
    }

    public function getNoteForCell($service, $spreadsheetId, $range, $column, $row)
        {
            // Fungsi untuk mendapatkan catatan (note) dari sel
            $noteResponse = $service->spreadsheets->get($spreadsheetId, ['ranges' => $range, 'fields' => 'sheets.data.rowData.values.note']);
            $note = $noteResponse->getSheets()[0]->getData()[0]->getRowData()[$row - 4]->getValues()[$column]->getNote();
            return $note;
        }

        public function getBackgroundColorForCell($service, $spreadsheetId, $range, $column, $row)
        {
            // Fungsi untuk mendapatkan warna latar belakang dari sel
            $colorResponse = $service->spreadsheets->get($spreadsheetId, ['ranges' => $range, 'fields' => 'sheets.data.rowData.values.effectiveFormat.backgroundColor']);
            $color = $colorResponse->getSheets()[0]->getData()[0]->getRowData()[$row - 4]->getValues()[$column]->getEffectiveFormat()->getBackgroundColor();
            return $color;
        }
}


