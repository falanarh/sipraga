<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email:dns',
                'password' => 'required'
            ],
            [
                'email.required' => 'Email wajib diisi!',
                'email.email' => 'Email harus berformat email yang valid!',
                'password.required' => 'Password wajib diisi!'
            ]
        );

        $info_login = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($info_login, $request->has('remember'))) {
            return redirect('profiling');
            //     $user = Auth::user();
            // // Mengambil peran (roles) dari pengguna
            // $roles = $user->roles->pluck('name')->toArray();

            // if (in_array('Admin', $roles)) {
            //     return redirect('/admin/data-master');
            // } elseif (in_array('Koordinator', $roles)) {
            //     return redirect('/koordinator/jadwal-pengecekan-kelas');
            // } elseif (in_array('Pelapor', $roles)) {
            //     return redirect('/pelapor/buat-pengaduan');
            // } elseif (in_array('PemakaiBHP', $roles)) {
            //     return redirect('/pemakaibhp/pengambilan');
            // } elseif (in_array('Teknisi', $roles)) {
            //     return redirect('/teknisi/jadwal-pemeliharaan');
            // } else {
            //     return redirect('/login');
            // }
            
            // if (Auth::user()->role == 'Admin') {
            //     return redirect('/admin/data-master');
            // } elseif (Auth::user()->role == 'Koordinator') {
            //     return redirect('/koordinator/jadwal-pengecekan-kelas');
            // } elseif (Auth::user()->role == 'Pelapor') {
            //     return redirect('/pelapor/buat-pengaduan');
            // } elseif (Auth::user()->role == 'PemakaiBHP') {
            //     return redirect('/pemakaibhp/pengambilan');
            // } else {
            //     return redirect('/teknisi/jadwal-pemeliharaan');
            // }
        } else {
            return redirect('/login')->withErrors(['failed' => 'Email dan/atau Password tidak valid!'])->withInput();
        }
    }

    public function authenticated()
    {
        $user = Auth::user();

        // Mengambil peran (roles) dari pengguna
        $roles = $user->roles->pluck('name')->toArray();

        if (in_array('Admin', $roles)) {
            return redirect('/admin/data-master');
        } elseif (in_array('Koordinator', $roles)) {
            return redirect('/koordinator/jadwal-pengecekan-kelas');
        } elseif (in_array('Pelapor', $roles)) {
            return redirect('/pelapor/buat-pengaduan');
        } elseif (in_array('PemakaiBHP', $roles)) {
            return redirect('/pemakaibhp/pengambilan');
        } elseif (in_array('Teknisi', $roles)) {
            return redirect('/teknisi/jadwal-pemeliharaan');
        } else {
            return redirect('/login');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
