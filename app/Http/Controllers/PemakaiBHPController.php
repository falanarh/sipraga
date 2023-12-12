<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Ruang;
use App\Models\BarangHabisPakai;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PemakaiBHPController extends Controller
{
    private function getUserInfo()
    {
        $userInfo = [
            'name' => Auth::user()->name,
            // 'role' => Auth::user()->role,
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

    public function pengambilan(){
        $userInfo = $this->getUserInfo();
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'PemakaiBHP');
        })->get();        
        // dd("Test");
        $ruangOptions = Ruang::all();
        $bhps = BarangHabisPakai::select([
            'jenis_barang'])
            ->groupBy('jenis_barang')
            ->get();


        return view('roles.pemakaibhp.pengambilan-pemakaibhp', compact('userInfo', 'users', 'bhps', 'ruangOptions'));
    }
}
