<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserInformation
{
    private $user;

    public function __construct()
    {
        // Mengambil user yang sedang login
        $this->user = Auth::user();
    }

    public function getUserInfo()
    {
        $userInfo = [
            'name' => $this->user->name,
            'photo' => $this->user->picture_link,
            'timeOfDay' => $this->getTimeOfDay(),
        ];
        return $userInfo;
    }

    private function getTimeOfDay()
    {
        $now = Carbon::now('Asia/Jakarta'); // Set zona waktu ke WIB
        $hour = $now->hour;

        if ($hour >= 5 && $hour < 12) {
            return "Pagi";
        } elseif ($hour >= 12 && $hour < 17) {
            return "Siang";
        } elseif ($hour >= 17 && $hour < 20) {
            return "Sore";
        } else {
            return "Malam";
        }
    }

    public function getEmailWithoutDomain($email)
    {
        // Mengambil email tanpa karakter @ dan domainnya
        $emailParts = explode('@', $email);

        if (count($emailParts) === 2) {
            return $emailParts[0];
        }

        return null; // Atau sesuaikan dengan kebutuhan lain jika email tidak valid
    }
}
