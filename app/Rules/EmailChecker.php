<?php

namespace App\Rules;

class EmailChecker
{
    public function isNumericEmailCharacters($email)
    {
        // Pisahkan email menjadi bagian sebelum "@" dan domain
        list($username, $domain) = explode('@', $email, 2);

        // Cek apakah setiap karakter dalam username merupakan angka
        for ($i = 0; $i < strlen($username); $i++) {
            if (!is_numeric($username[$i])) {
                return false; // Jika ditemukan karakter bukan angka, kembalikan false
            }
        }

        return true; // Jika semua karakter adalah angka, kembalikan true
    }

    public function hasStisDomain($email)
    {
        // Pisahkan email menjadi bagian sebelum "@" dan domain
        list($username, $domain) = explode('@', $email, 2);

        // Cek apakah domain adalah "stis.ac.id"
        return strtolower($domain) === 'stis.ac.id';
    }
}