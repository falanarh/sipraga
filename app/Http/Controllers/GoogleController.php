<?php

namespace App\Http\Controllers;

use App\Helpers\UserFormatter;
use App\Models\Role;
use App\Models\User;
use App\Rules\EmailChecker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $existing_user = User::where('google_id', $user->getId())->first();

            if ($existing_user) {
                Auth::login($existing_user);
                return redirect('profiling');
            } else {
                $emailChecker = new EmailChecker();
                $userFormatter = new UserFormatter();

                if ($emailChecker->hasStisDomain($user->getEmail())) {
                    $new_user = User::create([
                        'google_id' => $user->getId(),
                        'name' => $userFormatter->formatFullName($user->getName()),
                        'email' => $user->getEmail(),
                        'password' => bcrypt('12345678'),
                        'picture_link' => $user->getAvatar()
                    ]);

                    // Sisipkan peran (role) ke dalam tabel role_user
                    $roles = Role::whereIn('name', ['Pelapor', 'PemakaiBHP'])->get();

                    // Loop through roles and attach them one by one
                    foreach ($roles as $role) {
                        $new_user->roles()->attach($role);
                    }
                    // Login pengguna baru
                    Auth::login($new_user);
                    return redirect('profiling');
                } else {
                    // Tindakan yang ingin Anda lakukan jika domain tidak sesuai
                    return redirect('/login')->with('error', 'Email domain tidak valid.');
                }
            }
        } catch (\Throwable $th) {
            // Tangani kesalahan di sini
            // Memberikan respons yang sesuai
            return redirect('/login')->with('error', 'Terjadi kesalahan saat proses login.');
        }
    }
}
