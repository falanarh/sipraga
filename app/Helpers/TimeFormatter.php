<?php

namespace App\Helpers;

use DateTime;
use Exception;

class TimeFormatter
{
    public function formatDate($date)
    {
        return date('Y-m-d', strtotime($date));
    }

    public function formatDateDMY($date)
    {
        return date('d-m-Y', strtotime($date));
    }

    function extractMonthAndYear($input)
    {
        // Parsing input menggunakan explode
        list($month, $year) = explode('-', $input);

        // Mendapatkan nama bulan dalam bahasa Indonesia
        $monthName = $this->getIndonesianMonthName((int)$month);

        // Mendapatkan dua digit terakhir tahun
        $lastTwoDigitsOfYear = substr($year, -2);

        return [
            'monthName' => $monthName,
            'lastTwoDigitsOfYear' => $lastTwoDigitsOfYear,
        ];
    }

    function extractDateComponents($dateString)
    {
        // Convert the date string to a DateTime object
        $date = new DateTime($dateString);

        // Extract day, month, and year components
        $day = $date->format('d');
        $month = $date->format('m');
        $year = $date->format('y');

        // Mendapatkan nama bulan dalam bahasa Indonesia
        $monthName = $this->getIndonesianMonthName((int)$month);

        // Return the components as an associative array
        return ['day' => $day, 'monthName' => $monthName, 'year' => $year];
    }

    function getIndonesianMonthName($monthNumber)
    {
        $monthNames = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        return $monthNames[$monthNumber] ?? 'Invalid month';
    }

    function extractTimeRangesFromString($input)
    {
        // Pola regex untuk mencocokkan format waktu tertentu, dengan atau tanpa spasi
        $pattern = '/(\d{1,2}[:.]\d{2})\s*-\s*([sS]elesai|\d{1,2}[:.]\d{2})/';

        // Inisialisasi array untuk menyimpan rentang waktu
        $timeRanges = [];

        // Pencocokan pola regex pada string input
        preg_match_all($pattern, $input, $matches, PREG_SET_ORDER);

        // Menyimpan hasil pencocokan dalam array
        foreach ($matches as $match) {
            $startTime = str_replace('.', ':', $match[1]);
            $endTime = strtoupper($match[2]) === 'SELESAI' ? '23:59' : str_replace('.', ':', $match[2]);

            $timeRanges[] = [
                'start' => $startTime,
                'end' => $endTime,
            ];
        }

        return $timeRanges;
    }

    function parseTimeRange($input)
    {
        // Pola regex untuk mencocokkan format waktu tertentu
        $pattern = '/(\d{1,2}[:.]\d{2})-(\d{1,2}[:.]\d{2})/';

        // Pencocokan pola regex pada string input
        if (preg_match($pattern, $input, $matches)) {
            // Mengambil waktu mulai dan waktu selesai dari hasil pencocokan
            $startTime = str_replace('.', ':', $matches[1]);
            $endTime = str_replace('.', ':', $matches[2]);

            // Mengembalikan hasil dalam bentuk array asosiatif
            return [
                'start' => $startTime,
                'end' => $endTime,
            ];
        } else {
            // Mengembalikan nilai null jika format tidak cocok
            return null;
        }
    }

    function isTimeRangeAvailable($proposedTime, $existingSchedule)
    {
        foreach ($existingSchedule as $schedule) {
            // Convert schedule start and end times to UNIX timestamps
            $startSchedule = strtotime($schedule['start']);
            $endSchedule = strtotime($schedule['end']);

            // Convert proposed time start and end times to UNIX timestamps
            $startProposed = strtotime($proposedTime['start']);
            $endProposed = strtotime($proposedTime['end']);

            // Check for overlap between proposed time and each existing schedule
            if (
                ($startProposed >= $startSchedule && $startProposed < $endSchedule) ||
                ($endProposed > $startSchedule && $endProposed <= $endSchedule) ||
                ($startProposed <= $startSchedule && $endProposed >= $endSchedule)
            ) {
                return false; // There is an overlap, time range is not available
            }
        }

        return true; // No overlap found, time range is available
    }
}
