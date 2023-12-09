<?php

namespace App\Helpers;

class UserFormatter
{
    /**
     * Format nama lengkap user dengan huruf pertama di setiap kata kapital.
     *
     * @param  string  $fullName
     * @return string
     */
    public static function formatFullName($fullName)
    {
        // Gunakan ucwords untuk mengubah huruf pertama di setiap kata menjadi kapital
        return ucwords(strtolower($fullName));
    }
}