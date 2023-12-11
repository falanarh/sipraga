<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mahasiswa;
use App\Rules\EmailChecker;
use Illuminate\Http\Request;
use App\Helpers\UserInformation;
use Illuminate\Support\Facades\Auth;

class MahasiswaController extends Controller
{
    public function store()
    {
        $user = Auth::user();
        $email_user = $user->email;

        $emailChecker = new EmailChecker();
        if ($emailChecker->hasStisDomain($email_user)) {
            // Cari mahasiswa berdasarkan email
            $mahasiswa = Mahasiswa::where('user_id', $user->user_id)->first();
            if (!$mahasiswa) {
                $userInformation = new UserInformation();
                $nim = $userInformation->getEmailWithoutDomain($email_user);
                // Insert data mahasiswa baru
                $mahasiswa = Mahasiswa::create([
                    'user_id' => $user->user_id,
                    'nim' => $nim,
                ]);
            }
            return redirect('pilih-peran');
        }
    }

    public function edit(Request $request, $user_id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tgl_lahir' => 'required|date',
            'no_telp' => 'nullable|string|regex:/^[0-9]+$/|max:20',
            'alamat' => 'nullable|string',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:500', // Maksimum 500 KB
        ], [
            'name.required' => 'Nama harus diisi!',
            'name.string' => 'Nama harus berupa teks!',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter!',
            
            'tempat_lahir.required' => 'Tempat lahir harus diisi!',
            'tempat_lahir.string' => 'Tempat lahir harus berupa teks!',
            'tempat_lahir.max' => 'Tempat lahir tidak boleh lebih dari 255 karakter!',
            
            'tgl_lahir.required' => 'Tanggal lahir harus diisi!',
            'tgl_lahir.date' => 'Format tanggal lahir tidak valid!',
            
            'no_telp.string' => 'Nomor telepon harus berupa teks!',
            'no_telp.max' => 'Nomor telepon tidak boleh lebih dari 20 karakter!',
            'no_telp.regex' => 'Nomor telepon harus berupa angka!',
            
            'alamat.string' => 'Alamat harus berupa teks!',
            
            'profile_picture.image' => 'File harus berupa gambar!',
            'profile_picture.mimes' => 'Format gambar tidak valid. Hanya mendukung JPEG, PNG, JPG, dan GIF!',
            'profile_picture.max' => 'Ukuran gambar tidak boleh lebih dari 500 KB!',
        ]);
        

        $mahasiswa = Mahasiswa::where('user_id', $user_id)->firstOrFail();
        $mahasiswa->kelas = $request->kelas;
        $mahasiswa->tempat_lahir = $request->tempat_lahir;
        $mahasiswa->tgl_lahir = $request->tgl_lahir;
        $mahasiswa->no_telp = $request->no_telp;
        $mahasiswa->alamat = $request->alamat;
        $mahasiswa->save();

        $user = User::where('user_id', $user_id)->firstOrFail();
        $user->name = $request->name;
        $user->save();

         // Update foto profil jika ada
         if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/profile_pictures', $fileName);
            $user->picture_link = 'storage/profile_pictures/' . $fileName;
            $user->save();
        }

        return redirect()->route('profil', ['role' => $request->role])->with([
            'success' => 'Profil berhasil diedit!',
        ]);
    }
}
