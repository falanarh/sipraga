<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){
        return view('login');
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required'
        ], [
            'email.required' => 'Email wajib diisi!',
            'email.email' => 'Email harus berformat email yang valid!',
            'password.required' => 'Password wajib diisi!'
        ]
        );

        $info_login = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if(Auth::attempt($info_login, $request->has('remember'))){
            if(Auth::user()->role == 'Admin'){
                return redirect('/admin/data-master');
            } elseif(Auth::user()->role == 'Koordinator'){
                return redirect('/koordinator/jadwal-pengecekan-kelas');
            } elseif(Auth::user()->role == 'Pelapor'){
                return redirect('/pelapor/buat-pengaduan');
            } elseif(Auth::user()->role == 'PemakaiBHP'){
                return redirect('/pemakaibhp/pengambilan');   
            } else {
                return redirect('/teknisi/jadwal-pemeliharaan');   
            }
        } else {
            return redirect('/login')->withErrors(['failed' => 'Email dan/atau Password tidak valid!'])->withInput();
        }   
    }

    public function authenticated(){
        if(Auth::user()->role == 'Admin'){
            return redirect('/admin/data-master');
        } elseif(Auth::user()->role == 'Koordinator'){
            return redirect('/koordinator/jadwal-pengecekan-kelas');
        } elseif(Auth::user()->role == 'Pelapor'){
            return redirect('/pelapor/buat-pengaduan');
        } elseif(Auth::user()->role == 'PemakaiBHP'){
            return redirect('/pemakaibhp/pengambilan');   
        } elseif(Auth::user()->role == 'Teknisi') {
            return redirect('/teknisi/jadwal-pemeliharaan');   
        } else {
            return redirect('/login');
        }
    }

    public function logout() {
        Auth::logout();
        return redirect('/login');
    }
}
