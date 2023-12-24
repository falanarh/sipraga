<?php

use App\Models\User;
use App\Models\Dosen;
use App\Models\Staff;
use App\Models\Mahasiswa;
use App\Rules\EmailChecker;
use App\Models\PengecekanKelas;
use App\Helpers\UserInformation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AsetController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RuangController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\PelaporController;
use App\Http\Controllers\TeknisiController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\PerbaikanController;
use App\Http\Controllers\ImportAsetController;
use App\Http\Controllers\PemakaiBHPController;
use App\Http\Controllers\ImportRuangController;
use App\Http\Controllers\KoordinatorController;
use App\Http\Controllers\PemeliharaanAcController;
use App\Http\Controllers\PengecekanKelasController;
use App\Http\Controllers\BarangHabisPakaiController;
use App\Http\Controllers\JadwalPemeliharaanAcController;
use App\Http\Controllers\AmbilBarangHabisPakaiController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Login
Route::middleware(['guest'])->group(function () {
    Route::get('/', function () {
        return redirect('/home');
    });
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/storage/{filename}', 'StorageController@show')->name('storage.show');
    //Logout
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('authenticated', [LoginController::class, 'authenticated'])->name('authenticated');
    Route::get('profiling', function () {
        $user = Auth::user();
        $emailChecker = new EmailChecker();
        $user_email = $user->email;

        $roles = $user->roles->pluck('name')->toArray();

        if (in_array('Admin', $roles) || in_array('Teknisi', $roles) || in_array('Koordinator', $roles)) {
            return redirect('staff');
        } else {
            if ($emailChecker->isNumericEmailCharacters($user_email)) {
                return redirect('mahasiswa');
            } else {
                return redirect('dosen');
            }
        }
    });
    Route::get('mahasiswa', [MahasiswaController::class, 'store'])->name('mahasiswa');
    Route::get('dosen', [DosenController::class, 'store'])->name('dosen');
    Route::get('staff', [StaffController::class, 'store'])->name('staff');
    Route::get('/home', [LoginController::class, 'authenticated'])->name('home');
    Route::get('pilih-peran', function () {
        return view('roles.pilih-peran');
    });
    Route::get('/{role}/profil', function ($role) {
        $userInfoManager = new UserInformation();
        $userInfo = $userInfoManager->getUserInfo();
        $loggedInUser = Auth::user();
        $user = User::where('user_id', $loggedInUser->user_id)->first();
        $userRoles = $user->roles()->pluck('name')->toArray(); // Ambil nama-nama role

        $mahasiswa = Mahasiswa::where('user_id', $user->user_id)->first();
        $dosen = Dosen::where('user_id', $user->user_id)->first();
        $staff = Staff::where('user_id', $user->user_id)->first();

        if ($mahasiswa) {
            $posisi = "Mahasiswa";
        } elseif ($dosen) {
            $posisi = "Dosen";
        } else {
            $posisi = "Staff";
        }

        // Memeriksa apakah role user termasuk dalam daftar yang diizinkan
        $allowedRoles = ['Admin', 'Teknisi', 'Koordinator', 'Pelapor', 'Pemakai BHP'];
        if (!empty(array_intersect($userRoles, $allowedRoles))) {
            // Jika termasuk, kembalikan view yang sesuai
            if ($posisi == 'Mahasiswa') {
                return view('roles.profile', compact('userInfo', 'user', 'mahasiswa', 'role', 'posisi'));
            } elseif ($posisi == 'Dosen') {
                return view('roles.profile', compact('userInfo', 'user', 'dosen', 'role', 'posisi'));
            } else {
                return view('roles.profile', compact('userInfo', 'user', 'staff', 'role', 'posisi'));
            }
        } else {
            // Jika tidak termasuk, Anda dapat mengarahkan ke halaman lain atau memberikan respons sesuai kebutuhan
            abort(403, 'Unauthorized');
        }
    })->name('profil');
    Route::patch('edit/mahasiswa/{user_id}', [MahasiswaController::class, 'edit'])->name('edit-profil-mahasiswa');
    Route::patch('edit/dosen/{user_id}', [DosenController::class, 'edit'])->name('edit-profil-dosen');
    Route::patch('edit/staff/{user_id}', [StaffController::class, 'edit'])->name('edit-profil-staff');

    Route::get('ruangsForCalendar', [RuangController::class, 'getRuangsForCalendar'])->name('getRuangsForCalendar');

    // Route untuk Teknisi
    Route::middleware(['userAkses:Teknisi'])->group(function () {
        Route::get('/teknisi/daftar-pengaduan', [TeknisiController::class, 'daftarPengaduan']);
        Route::get('/teknisi/daftar-pengaduan/view', [PengaduanController::class, 'dataTeknisi'])->name('teknisi.daftar-pengaduan.view');
        Route::get('/teknisi/daftar-pengaduan/detail/{tiket}', [TeknisiController::class, 'daftarPengaduanDetail'])->name('teknisi.daftar-pengaduan-detail');
        Route::get('/teknisi/jadwal-pemeliharaan', [TeknisiController::class, 'jadwalPemeliharaan'])->name('teknisi.jadwal');
        Route::get('/teknisi/jadwal-pemeliharaan/set/{jadwal_pemeliharaan_ac_id}/{teknisi_id}', [JadwalPemeliharaanAcController::class, 'setTeknisiId'])->name('teknisi.jadwal.set');
        Route::get('/teknisi/jadwal-pemeliharaan/generate', [JadwalPemeliharaanAcController::class, 'generateJadwal'])->name('teknisi.jadwal.generate');
        Route::get('/teknisi/jadwal-pemeliharaan/ac', [JadwalPemeliharaanAcController::class, 'data'])->name('teknisi.jadwal.ac');
        Route::get('/teknisi/jadwal-pemeliharaan/pemeliharaan/{jadwal_pemeliharaan_ac_id}/edit', [TeknisiController::class, 'pemeliharaan'])->name('teknisi.jadwal.pemeliharaan-form');
        Route::post('/teknisi/jadwal-pemeliharaan/pemeliharaan/{jadwal_pemeliharaan_ac_id}/edit', [PemeliharaanAcController::class, 'store'])->name('teknisi.jadwal.pemeliharaan.store');
        Route::get('/teknisi/jadwal-pemeliharaan/pemeliharaan', [TeknisiController::class, 'pemeliharaan']);
        // Route::get('/teknisi/daftar-pemeliharaan', [TeknisiController::class, 'daftarPemeliharaan']);
        // Route::get('/teknisi/daftar-pemeliharaan/detail', [TeknisiController::class, 'daftarPemeliharaanDetail']);
        Route::get('/teknisi/daftar-pemeliharaan', [TeknisiController::class, 'daftarPemeliharaan'])->name('teknisi.daftar-pemeliharaan');
        Route::get('/teknisi/daftar-pemeliharaan/view', [PemeliharaanAcController::class, 'data'])->name('teknisi.daftar-pemeliharaan.view');
        Route::get('/teknisi/daftar-pemeliharaan/ekspor', [PemeliharaanAcController::class, 'eksporPemeliharaan'])->name('teknisi.daftar-pemeliharaan.ekspor');
        Route::get('/teknisi/daftar-pemeliharaan/detail/{pemeliharaan_ac_id}', [TeknisiController::class, 'daftarPemeliharaanDetail'])->name('teknisi.daftar-pemeliharaan-detail');
        Route::get('/teknisi/daftar-pemeliharaan/detail/{pemeliharaan_ac_id}/edit', [TeknisiController::class, 'editDaftarPemeliharaanDetail'])->name('teknisi.daftar-pemeliharaan-detail.edit');
        Route::patch('/teknisi/daftar-pemeliharaan/detail/{pemeliharaan_ac_id}/edit', [PemeliharaanAcController::class, 'update'])->name('teknisi.daftar-pemeliharaan-detail.edit');
        Route::get('/teknisi/daftar-pemeliharaan/detail/{pemeliharaan_ac_id}/ekspor', [PemeliharaanAcController::class, 'eksporPemeliharaanDetail'])->name('teknisi.daftar-pemeliharaan-detail.ekspor');
        Route::get('/teknisi/daftar-pengaduan/detail/catat/{tiket}', [TeknisiController::class, 'perbaikan']);
        Route::get('/teknisi/daftar-perbaikan', [TeknisiController::class, 'daftarPerbaikan'])->name('teknisi.daftar-perbaikan');
        Route::get('/teknisi/daftar-perbaikan/view', [PerbaikanController::class, 'dataTeknisi'])->name('teknisi.daftar-perbaikan.view');
        Route::post('/teknisi/daftar-pengaduan/detail/catat/{tiket}', [PerbaikanController::class, 'store'])->name('teknisi.perbaikan.store');
        Route::get('/teknisi/daftar-perbaikan/detail/{tiket}', [TeknisiController::class, 'daftarPerbaikanDetail'])->name('teknisi.daftar-perbaikan-detail');
        Route::get('/teknisi/daftar-perbaikan/detail/update/{tiket}', [TeknisiController::class, 'editPerbaikan'])->name('teknisi.edit-perbaikan');
        Route::put('/teknisi/daftar-perbaikan/detail/update/{tiket}', [PerbaikanController::class, 'update'])->name('teknisi.update-perbaikan');
     });

    // Route untuk Admin
    Route::middleware(['userAkses:Admin'])->group(function () {
        Route::get('/admin/data-ruangan', [AdminController::class, 'dataRuangan'])->name('admin.data-ruangan');
        Route::get('/admin/data-ruangan/view', [RuangController::class, 'data'])->name('admin.data-ruangan.view');
        Route::get('/admin/data-ruangan/{kode_ruang}/edit', [AdminController::class, 'editRuangan'])->name('admin.data-ruangan.edit');
        Route::put('/admin/data-ruangan/{kode_ruang}/edit', [RuangController::class, 'update'])->name('admin.data-ruangan.edit');
        Route::get('/admin/data-ruangan/{kode_ruang}/hapus', [RuangController::class, 'remove'])->name('admin.data-ruangan.hapus');
        Route::get('/admin/ketersediaan-ruangan', [AdminController::class, 'ketersediaanRuangan']);
        Route::get('/admin/ketersediaan-ruangan/detail', [AdminController::class, 'ketersediaanRuanganDetail']);
        // Route::get('/admin/data-ruangan/edit-ruang', [AdminController::class, 'editRuangan']);

        //Route::post('api/peminjaman-ruangan/store', [PeminjamanRuanganController::class, 'store']);
        Route::get('/admin/data-ruangan/tambah-ruang', [AdminController::class, 'tambahRuangan']);
        Route::post('/admin/data-ruangan/tambah-ruang/impor', [ImportRuangController::class, 'import'])->name('admin.data-ruangan.impor');
        Route::post('/admin/data-ruangan/tambah-ruang', [RuangController::class, 'store'])->name('admin.data-ruangan.store');
        Route::get('/admin/pengelolaan-peminjaman', [AdminController::class, 'pengelolaanPeminjaman']);
        Route::get('/admin/pengelolaan-peminjaman/detail', [AdminController::class, 'pengelolaanPeminjamanDetail']);
        Route::get('/admin/data-master', [AdminController::class, 'dataMaster'])->name('admin.data-master');
        Route::get('/admin/data-master/view-dbr', [AsetController::class, 'eksporDbr'])->name('admin.data-master.dbr');
        Route::get('/admin/data-master/{kode_barang}/edit', [AdminController::class, 'editJenis'])->name('admin.data-master.jenis.edit-form');
        Route::put('/admin/data-master/{kode_barang}/edit', [BarangController::class, 'update'])->name('admin.data-master.jenis.edit');
        Route::get('/admin/data-master/{kode_barang}/hapus', [BarangController::class, 'remove'])->name('admin.data-master.jenis.hapus');
        Route::get('/admin/data-master/jenis', [BarangController::class, 'data'])->name('admin.data-master.jenis');
        Route::get('/admin/data-master/sarpras', [AsetController::class, 'data'])->name('admin.data-master.sarpras');
        Route::get('/admin/data-master/tambah-sarpras', [AdminController::class, 'tambahSarpras'])->name('admin.tambah-sarpras');
        Route::post('/admin/data-master/tambah-sarpras', [AsetController::class, 'store'])->name('admin.tambah-sarpras.store');
        Route::post('/admin/data-master/impor-sarpras', [ImportAsetController::class, 'import'])->name('admin.impor-sarpras');
        Route::get('/admin/data-master/tambah-jenis', [AdminController::class, 'tambahJenis'])->name('admin.tambah-jenis');
        Route::post('/admin/data-master/tambah-jenis', [BarangController::class, 'store'])->name('admin.tambah-jenis.store');
        Route::get('/admin/data-master/{kode_barang}/{nup}/edit', [AdminController::class, 'editSarpras'])->name('admin.data-master.sarpras.edit-form');
        Route::patch('/admin/data-master/{kode_barang}/{nup}/edit', [AsetController::class, 'update'])->name('admin.data-master.sarpras.edit');
        Route::get('/admin/data-master/{kode_barang}/{nup}/hapus', [AsetController::class, 'remove'])->name('admin.data-master.sarpras.hapus');
        Route::get('/admin/data-master/{kode_barang}/{nup}/detail', [AdminController::class, 'dataMasterDetail'])->name('admin.data-master.sarpras.detail');
        Route::get('/admin/jadwal-pengecekan-kelas', [AdminController::class, 'jadwalPengecekanKelas'])->name('admin.jadwal-pengecekan-kelas');
        Route::get('/admin/jadwal-pengecekan-kelas/view', [PengecekanKelasController::class, 'dataAdmin'])->name('admin.jadwal-pengecekan-kelas.view');
        Route::get('/admin/jadwal-pengecekan-kelas/penugasan/{pengecekan_kelas_id}', [PengecekanKelasController::class, 'selesaikan'])->name('admin.jadwal-pengecekan-kelas.selesaikan');
        Route::get('/admin/barang-habis-pakai', [AdminController::class, 'barangHabisPakai'])->name('admin.bhp');
        Route::get('/admin/barang-habis-pakai/view/bhp', [BarangHabisPakaiController::class, 'dataBHP'])->name('admin.bhp.view.dataBHP');
        Route::get('/admin/barang-habis-pakai/view/ambil-bhp', [AmbilBarangHabisPakaiController::class, 'dataAmbilBHP'])->name('admin.bhp.view.dataAmbilBHP');
        Route::get('/admin/barang-habis-pakai/view/transaksi-bhp', [BarangHabisPakaiController::class, 'dataTransaksiBHP'])->name('admin.bhp.view.dataTransaksiBHP');
        Route::get('/admin/barang-habis-pakai/tambah-bhp', [AdminController::class, 'tambahBHP'])->name('admin.bhp.tambah-form');
        // Route::get('/admin/barang-habis-pakai/notifikasi', [BarangHabisPakaiController::class, 'notifikasi'])->name('admin.bhp.notifikasi');
        Route::post('/admin/barang-habis-pakai/tambah-bhp', [BarangHabisPakaiController::class, 'store'])->name('admin.bhp.tambah');
        Route::get('/admin/barang-habis-pakai/tambah-jenis-bhp', [AdminController::class, 'tambahJenisBHP'])->name('admin.bhp.tambah-jenis-form');
        Route::post('/admin/barang-habis-pakai/tambah-jenis-bhp', [BarangHabisPakaiController::class, 'jenisBHP'])->name('admin.bhp.tambah-jenis-bhp');
        Route::get('/admin/barang-habis-pakai/{pengambilan_bhp_id}/hapus-pengambilan-bhp', [AmbilBarangHabisPakaiController::class, 'hapusPengambilanBHP'])->name('admin.bhp.hapus-pengambilan-bhp');
        Route::get('/admin/barang-habis-pakai/{id}/edit-form', [AdminController::class, 'showBhpEditForm'])->name('admin.bhp.edit-form');
        Route::patch('/admin/barang-habis-pakai/{id}/edit', [BarangHabisPakaiController::class, 'editTransaksiBHP'])->name('admin.bhp.edit');
        Route::get('/admin/barang-habis-pakai/{id}/hapus-transaksi-bhp', [BarangHabisPakaiController::class, 'hapusTransaksiBHP'])->name('admin.bhp.hapus-transaksi-bhp');
        Route::get('/admin/barang-habis-pakai/{jenis_barang}/hapus-bhp', [BarangHabisPakaiController::class, 'hapusBHP'])->name('admin.bhp.hapus-bhp');
        Route::post('/admin/barang-habis-pakai/print-pengambilan-bhp', [AmbilBarangHabisPakaiController::class, 'eksporBHP'])->name('admin.bhp.print-pengambilan-bhp');
        Route::post('/admin/barang-habis-pakai/print-pengambilan-bhp', [AmbilBarangHabisPakaiController::class, 'eksporBHP'])->name('admin.bhp.print-pengambilan-bhp');
        Route::get('/cetak-bhp',function(){
           return view('export.format-bhp');
        });
        
        //{id} itu merupakan parameter yang dikirimkan
    });

    // Route untuk Koordinator
    Route::middleware(['userAkses:Koordinator'])->group(function () {
        Route::get('/koordinator/jadwal-pengecekan-kelas', [KoordinatorController::class, 'jadwalPengecekanKelas'])->name('koordinator.jadwal-pengecekan-kelas');
        Route::get('/koordinator/jadwal-pengecekan-kelas/view', [PengecekanKelasController::class, 'dataKoordinator'])->name('koordinator.jadwal-pengecekan-kelas.view');
        Route::get('/koordinator/jadwal-pengecekan-kelas/tambah', [KoordinatorController::class, 'tambahJadwal'])->name('koordinator.jadwal-pengecekan-kelas.tambah-form');
        Route::post('/koordinator/jadwal-pengecekan-kelas/tambah-awal', [PengecekanKelasController::class, 'store'])->name('koordinator.jadwal-pengecekan-kelas.store');
        Route::post('/koordinator/jadwal-pengecekan-kelas/tambah-baru', [PengecekanKelasController::class, 'generate'])->name('koordinator.jadwal-pengecekan-kelas.generate');
        Route::get('/koordinator/jadwal-pengecekan-kelas/penugasan/{pengecekan_kelas_id}', [KoordinatorController::class, 'penugasan'])->name('koordinator.jadwal-pengecekan-kelas.penugasan-form');
        Route::post('/koordinator/jadwal-pengecekan-kelas/penugasan/{pengecekan_kelas_id}', [PengecekanKelasController::class, 'tugaskanAdmin'])->name('koordinator.jadwal-pengecekan-kelas.penugasan');
        Route::get('/koordinator/daftar-pengaduan', [KoordinatorController::class, 'daftarPengaduan'])->name('koordinator.daftar-pengaduan');
        Route::get('/koordinator/daftar-pengaduan/view', [PengaduanController::class, 'dataKoordinator'])->name('koordinator.daftar-pengaduan.view');
        Route::get('/koordinator/daftar-pengaduan/detail/{tiket}', [KoordinatorController::class, 'daftarPengaduanDetail'])->name('koordinator.daftar-pengaduan-detail');
        Route::put('/koordinator/daftar-pengaduan/detail/{tiket}', [KoordinatorController::class, 'updatePengaduan'])->name('koordinator.update-pengaduan');
        Route::post('/koordinator/daftar-pengaduan/detail/{tiket}', [KoordinatorController::class, 'tolakPengaduan'])->name('koordinator.tolak-pengaduan');
        Route::get('/koordinator/daftar-perbaikan', [KoordinatorController::class, 'daftarPerbaikan'])->name('koordinator.daftar-perbaikan');
        Route::get('/koordinator/daftar-perbaikan/view', [PerbaikanController::class, 'dataKoordinator'])->name('koordinator.daftar-perbaikan.view');
        Route::get('/koordinator/daftar-perbaikan/detail/{tiket}', [KoordinatorController::class, 'daftarPerbaikanDetail'])->name('koordinator.daftar-perbaikan-detail');
        Route::get('/koordinator/daftar-perbaikan/detail/print/{tiket}', [PerbaikanController::class, 'printPerbaikan'])->name('teknisi.daftar-perbaikan.print');
   });

    // Route untuk Pelapor
    Route::middleware(['userAkses:Pelapor'])->group(function () {
        Route::get('/pelapor/buat-pengaduan', [PelaporController::class, 'buatPengaduan']);
        Route::post('/pelapor/buat-pengaduan', [PengaduanController::class, 'store'])->name('pelapor.data-pengaduan.store');
        Route::get('/pelapor/daftar-pengaduan', [PelaporController::class, 'daftarPengaduan'])->name('pelapor.daftar-pengaduan');
        Route::get('/pelapor/daftar-pengaduan/view', [PengaduanController::class, 'data'])->name('pelapor.daftar-pengaduan.view');
        Route::get('/pelapor/daftar-pengaduan/detail/{tiket}', [PelaporController::class, 'daftarPengaduanDetail'])->name('pelapor.daftar-pengaduan-detail');
   });

    // Route untuk Pemakai BHP
    Route::middleware(['userAkses:PemakaiBHP'])->group(function () {
        Route::get('/pemakaibhp/pengambilan', [PemakaiBHPController::class, 'pengambilan'])->name('pemakaibhp.pengambilan');
        Route::post('/pemakaibhp/pengambilan', [AmbilBarangHabisPakaiController::class, 'store'])->name('pemakaibhp.pengambilan.ambil');
        // Route::get('/admin/barang-habis-pakai/view/AmbilBHP', [AmbilBarangHabisPakaiController::class, 'data'])->name('admin.bhp.view.ambilbhp');
    });
});

// //Falana
// Route::get('/teknisi/daftar-pengaduan', [TeknisiController::class, 'daftarPengaduan'])->middleware('userAkses:Teknisi');

// Route::get('/teknisi/daftar-pengaduan/detail', [TeknisiController::class, 'daftarPengaduanDetail']);

// Route::get('/admin/data-ruangan', [AdminController::class, 'dataRuangan']);

// Route::get('/admin/ketersediaan-ruangan', [AdminController::class, 'ketersediaanRuangan']);

// Route::get('/admin/ketersediaan-ruangan/detail', [AdminController::class, 'ketersediaanRuanganDetail']);

// Route::get('/admin/data-ruangan/edit-ruang', [AdminController::class, 'editRuangan']);

// Route::get('/admin/data-ruangan/tambah-ruang', [AdminController::class, 'tambahRuangan']);

// Route::get('/admin/pengelolaan-peminjaman', [AdminController::class, 'pengelolaanPeminjaman']);

// Route::get('/admin/pengelolaan-peminjaman/detail', [AdminController::class, 'pengelolaanPeminjamanDetail']);

// //Anggy
// Route::get('/admin/data-master', [AdminController::class, 'dataMaster']);

// Route::get('/admin/data-master/detail', [AdminController::class, 'dataMasterDetail']);

// Route::get('/admin/data-master/tambah-sarpras', [AdminController::class, 'tambahSarpras']);

// Route::get('/admin/data-master/edit-sarpras', [AdminController::class, 'editSarpras']);

// //Gita
// Route::get('/admin/jadwal-pengecekan-kelas', [AdminController::class, 'jadwalPengecekanKelas']);

// Route::get('/admin/barang-habis-pakai', [AdminController::class, 'barangHabisPakai']);

// Route::get('/admin/barang-habis-pakai/tambah-bhp', [AdminController::class, 'tambahBHP ']);

// Route::get('/koordinator/jadwal-pengecekan-kelas', [KoordinatorController::class, 'jadwalPengecekanKelas']);

// Route::get('/koordinator/jadwal-pengecekan-kelas/penugasan', [KoordinatorController::class, 'penugasan']);

// Route::get('/pemakaibhp/pengambilan', [PemakaiBHPController::class, 'pengambilan']);

// //Sari
// Route::get('/teknisi/jadwal-pemeliharaan', [TeknisiController::class, 'jadwalPemeliharaan']);

// Route::get('/teknisi/jadwal-pemeliharaan/pemeliharaan', [TeknisiController::class, 'pemeliharaan']);

// //Haykal
// Route::get('/teknisi/daftar-pemeliharaan', [TeknisiController::class, 'daftarPemeliharaan']);

// Route::get('/teknisi/daftar-pemeliharaan/detail', [TeknisiController::class, 'daftarPemeliharaanDetail']);

// //Sindu
// Route::get('/teknisi/daftar-pengaduan/detail/catat', [TeknisiController::class, 'perbaikan']);

// Route::get('/teknisi/daftar-perbaikan', [TeknisiController::class, 'daftarPerbaikan']);

// Route::get('/teknisi/daftar-perbaikan/detail', [TeknisiController::class, 'daftarPerbaikanDetail']);

// Route::get('/koordinator/daftar-pengaduan', [KoordinatorController::class, 'daftarPengaduan']);

// Route::get('/koordinator/daftar-pengaduan/detail', [KoordinatorController::class, 'daftarPengaduanDetail']);

// Route::get('/koordinator/daftar-perbaikan', [KoordinatorController::class, 'daftarPerbaikan']);

// Route::get('/koordinator/daftar-perbaikan/detail', [KoordinatorController::class, 'daftarPerbaikanDetail']);

// Route::get('/pelapor/buat-pengaduan', [PelaporController::class, 'buatPengaduan']);

// Route::get('/pelapor/daftar-pengaduan', [PelaporController::class, 'daftarPengaduan']);

// Route::get('/pelapor/daftar-pengaduan/detail', [PelaporController::class, 'daftarPengaduanDetail']);



// use App\Models\Mahasiswa;
// use App\Rules\EmailChecker;
// use App\Helpers\UserInformation;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\AsetController;
// use App\Http\Controllers\AdminController;
// use App\Http\Controllers\LoginController;
// use App\Http\Controllers\RuangController;
// use App\Http\Controllers\BarangController;
// use App\Http\Controllers\DosenController;
// use App\Http\Controllers\GoogleController;
// use App\Http\Controllers\PelaporController;
// use App\Http\Controllers\TeknisiController;
// use App\Http\Controllers\MahasiswaController;
// use App\Http\Controllers\ImportAsetController;
// use App\Http\Controllers\PemakaiBHPController;
// use App\Http\Controllers\ImportRuangController;
// use App\Http\Controllers\KoordinatorController;
// use App\Http\Controllers\BarangHabisPakaiController;
// use App\Http\Controllers\AmbilBarangHabisPakaiController;
// use App\Http\Controllers\PengecekanKelasController;
// use App\Http\Controllers\PeminjamanRuanganController;
// use App\Http\Controllers\JadwalPemeliharaanAcController;    
// use App\Http\Controllers\PemeliharaanAcController;
// use App\Http\Controllers\StaffController;
// use App\Models\Dosen;
// use App\Models\Staff;
// use App\Models\User;
// use App\Models\PengecekanKelas;
// use App\Http\Controllers\PengaduanController;
// use App\Http\Controllers\PerbaikanController;




// /*
// |--------------------------------------------------------------------------
// | Web Routes
// |--------------------------------------------------------------------------
// |
// | Here is where you can register web routes for your application. These
// | routes are loaded by the RouteServiceProvider within a group which
// | contains the "web" middleware group. Now create something great!
// |
// */
// //Login
// Route::middleware(['guest'])->group(function () {
//     Route::get('/', function () {
//         return redirect('/home');
//     });
//     Route::get('/login', [LoginController::class, 'index'])->name('login');
//     Route::post('/login', [LoginController::class, 'login']);
//     Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
//     Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');
// });

// Route::middleware(['auth'])->group(function () {
//     //Logout
//     Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
//     Route::get('authenticated', [LoginController::class, 'authenticated'])->name('authenticated');
//     Route::get('profiling', function () {
//         $user = Auth::user();
//         $emailChecker = new EmailChecker();
//         $user_email = $user->email;

//         $roles = $user->roles->pluck('name')->toArray();

//         if (in_array('Admin', $roles) || in_array('Teknisi', $roles) || in_array('Koordinator', $roles)) {
//             return redirect('staff');
//         } else {
//             if ($emailChecker->isNumericEmailCharacters($user_email)) {
//                 return redirect('mahasiswa');
//             } else {
//                 return redirect('dosen');
//             }
//         }
//     });
//     Route::get('mahasiswa', [MahasiswaController::class, 'store'])->name('mahasiswa');
//     Route::get('dosen', [DosenController::class, 'store'])->name('dosen');
//     Route::get('staff', [StaffController::class, 'store'])->name('staff');
//     Route::get('/home', [LoginController::class, 'authenticated'])->name('home');
//     Route::get('pilih-peran', function () {
//         return view('roles.pilih-peran');
//     });
//     Route::get('/{role}/profil', function ($role) {
//         $userInfoManager = new UserInformation();
//         $userInfo = $userInfoManager->getUserInfo();
//         $loggedInUser = Auth::user();
//         $user = User::where('user_id', $loggedInUser->user_id)->first();
//         $userRoles = $user->roles()->pluck('name')->toArray(); // Ambil nama-nama role

//         $mahasiswa = Mahasiswa::where('user_id', $user->user_id)->first();
//         $dosen = Dosen::where('user_id', $user->user_id)->first();
//         $staff = Staff::where('user_id', $user->user_id)->first();

//         if ($mahasiswa) {
//             $posisi = "Mahasiswa";
//         } elseif ($dosen) {
//             $posisi = "Dosen";
//         } else {
//             $posisi = "Staff";
//         }

//         // Memeriksa apakah role user termasuk dalam daftar yang diizinkan
//         $allowedRoles = ['Admin', 'Teknisi', 'Koordinator', 'Pelapor', 'Pemakai BHP'];
//         if (!empty(array_intersect($userRoles, $allowedRoles))) {
//             // Jika termasuk, kembalikan view yang sesuai
//             if ($posisi == 'Mahasiswa') {
//                 return view('roles.profile', compact('userInfo', 'user', 'mahasiswa', 'role', 'posisi'));
//             } elseif ($posisi == 'Dosen') {
//                 return view('roles.profile', compact('userInfo', 'user', 'dosen', 'role', 'posisi'));
//             } else {
//                 return view('roles.profile', compact('userInfo', 'user', 'staff', 'role', 'posisi'));
//             }
//         } else {
//             // Jika tidak termasuk, Anda dapat mengarahkan ke halaman lain atau memberikan respons sesuai kebutuhan
//             abort(403, 'Unauthorized');
//         }
//     })->name('profil');
//     Route::patch('edit/mahasiswa/{user_id}', [MahasiswaController::class, 'edit'])->name('edit-profil-mahasiswa');
//     Route::patch('edit/dosen/{user_id}', [DosenController::class, 'edit'])->name('edit-profil-dosen');
//     Route::patch('edit/staff/{user_id}', [StaffController::class, 'edit'])->name('edit-profil-staff');

//     Route::get('ruangsForCalendar', [RuangController::class, 'getRuangsForCalendar'])->name('getRuangsForCalendar');

//     // Route untuk Teknisi
//     Route::middleware(['userAkses:Teknisi'])->group(function () {
//         Route::get('/teknisi/daftar-pengaduan', [TeknisiController::class, 'daftarPengaduan']);
//         Route::get('/teknisi/daftar-pengaduan/detail', [TeknisiController::class, 'daftarPengaduanDetail']);
//         Route::get('/teknisi/jadwal-pemeliharaan', [TeknisiController::class, 'jadwalPemeliharaan'])->name('teknisi.jadwal');
//         Route::get('/teknisi/jadwal-pemeliharaan/set/{jadwal_pemeliharaan_ac_id}/{teknisi_id}', [JadwalPemeliharaanAcController::class, 'setTeknisiId'])->name('teknisi.jadwal.set');
//         Route::get('/teknisi/jadwal-pemeliharaan/generate', [JadwalPemeliharaanAcController::class, 'generateJadwal'])->name('teknisi.jadwal.generate');
//         Route::get('/teknisi/jadwal-pemeliharaan/ac', [JadwalPemeliharaanAcController::class, 'data'])->name('teknisi.jadwal.ac');
//         Route::get('/teknisi/jadwal-pemeliharaan/pemeliharaan/{jadwal_pemeliharaan_ac_id}/edit', [TeknisiController::class, 'pemeliharaan'])->name('teknisi.jadwal.pemeliharaan-form');
//         Route::post('/teknisi/jadwal-pemeliharaan/pemeliharaan/{jadwal_pemeliharaan_ac_id}/edit', [PemeliharaanAcController::class, 'store'])->name('teknisi.jadwal.pemeliharaan.store');
//         Route::get('/teknisi/daftar-pemeliharaan', [TeknisiController::class, 'daftarPemeliharaan'])->name('teknisi.daftar-pemeliharaan');
//         // Route::get('/teknisi/daftar-pemeliharaan/detail', [TeknisiController::class, 'daftarPemeliharaanDetail']);
//         Route::get('/teknisi/daftar-pemeliharaan/view', [PemeliharaanAcController::class, 'data'])->name('teknisi.daftar-pemeliharaan.view');
//         Route::get('/teknisi/daftar-pemeliharaan/ekspor', [PemeliharaanAcController::class, 'eksporPemeliharaan'])->name('teknisi.daftar-pemeliharaan.ekspor');
//         Route::get('/teknisi/daftar-pemeliharaan/detail/{pemeliharaan_ac_id}', [TeknisiController::class, 'daftarPemeliharaanDetail'])->name('teknisi.daftar-pemeliharaan-detail');
//         Route::get('/teknisi/daftar-pemeliharaan/detail/{pemeliharaan_ac_id}/edit', [TeknisiController::class, 'editDaftarPemeliharaanDetail'])->name('teknisi.daftar-pemeliharaan-detail.edit');
//         Route::patch('/teknisi/daftar-pemeliharaan/detail/{pemeliharaan_ac_id}/edit', [PemeliharaanAcController::class, 'update'])->name('teknisi.daftar-pemeliharaan-detail.edit');
//         Route::get('/teknisi/daftar-pemeliharaan/detail/{pemeliharaan_ac_id}/ekspor', [PemeliharaanAcController::class, 'eksporPemeliharaanDetail'])->name('teknisi.daftar-pemeliharaan-detail.ekspor');
//         // Route::get('/teknisi/daftar-pemeliharaan/detail/{pemeliharaan_ac_id}/ekspor', [PemeliharaanAcController::class, 'eksporPemeliharaanDetail'])->name('teknisi.daftar-pemeliharaan-detail.ekspor');
//         Route::get('/teknisi/daftar-pengaduan/detail/catat', [TeknisiController::class, 'perbaikan']);
//         Route::get('/teknisi/daftar-perbaikan', [TeknisiController::class, 'daftarPerbaikan']);
//         Route::get('/teknisi/daftar-perbaikan/detail', [TeknisiController::class, 'daftarPerbaikanDetail']);
//     });

//     // Route untuk Admin
//     Route::middleware(['userAkses:Admin'])->group(function () {
//         Route::get('/admin/data-ruangan', [AdminController::class, 'dataRuangan'])->name('admin.data-ruangan');
//         Route::get('/admin/data-ruangan/view', [RuangController::class, 'data'])->name('admin.data-ruangan.view');
//         Route::get('/admin/data-ruangan/{kode_ruang}/edit', [AdminController::class, 'editRuangan'])->name('admin.data-ruangan.edit');
//         Route::put('/admin/data-ruangan/{kode_ruang}/edit', [RuangController::class, 'update'])->name('admin.data-ruangan.edit');
//         Route::get('/admin/data-ruangan/{kode_ruang}/hapus', [RuangController::class, 'remove'])->name('admin.data-ruangan.hapus');
//         Route::get('/admin/ketersediaan-ruangan', [AdminController::class, 'ketersediaanRuangan']);
//         Route::get('/admin/ketersediaan-ruangan/detail', [AdminController::class, 'ketersediaanRuanganDetail']);
//         // Route::get('/admin/data-ruangan/edit-ruang', [AdminController::class, 'editRuangan']);

//         //Route::post('api/peminjaman-ruangan/store', [PeminjamanRuanganController::class, 'store']);
//         Route::get('/admin/data-ruangan/tambah-ruang', [AdminController::class, 'tambahRuangan']);
//         Route::post('/admin/data-ruangan/tambah-ruang/impor', [ImportRuangController::class, 'import'])->name('admin.data-ruangan.impor');
//         Route::post('/admin/data-ruangan/tambah-ruang', [RuangController::class, 'store'])->name('admin.data-ruangan.store');
//         Route::get('/admin/pengelolaan-peminjaman', [AdminController::class, 'pengelolaanPeminjaman']);
//         Route::get('/admin/pengelolaan-peminjaman/detail', [AdminController::class, 'pengelolaanPeminjamanDetail']);
//         Route::get('/admin/data-master', [AdminController::class, 'dataMaster'])->name('admin.data-master');
//         Route::get('/admin/data-master/view-dbr', [AsetController::class, 'eksporDbr'])->name('admin.data-master.dbr');
//         Route::get('/admin/data-master/{kode_barang}/edit', [AdminController::class, 'editJenis'])->name('admin.data-master.jenis.edit-form');
//         Route::put('/admin/data-master/{kode_barang}/edit', [BarangController::class, 'update'])->name('admin.data-master.jenis.edit');
//         Route::get('/admin/data-master/{kode_barang}/hapus', [BarangController::class, 'remove'])->name('admin.data-master.jenis.hapus');
//         Route::get('/admin/data-master/jenis', [BarangController::class, 'data'])->name('admin.data-master.jenis');
//         Route::get('/admin/data-master/sarpras', [AsetController::class, 'data'])->name('admin.data-master.sarpras');
//         Route::get('/admin/data-master/tambah-sarpras', [AdminController::class, 'tambahSarpras'])->name('admin.tambah-sarpras');
//         Route::post('/admin/data-master/tambah-sarpras', [AsetController::class, 'store'])->name('admin.tambah-sarpras.store');
//         Route::post('/admin/data-master/impor-sarpras', [ImportAsetController::class, 'import'])->name('admin.impor-sarpras');
//         Route::get('/admin/data-master/tambah-jenis', [AdminController::class, 'tambahJenis'])->name('admin.tambah-jenis');
//         Route::post('/admin/data-master/tambah-jenis', [BarangController::class, 'store'])->name('admin.tambah-jenis.store');
//         Route::get('/admin/data-master/{kode_barang}/{nup}/edit', [AdminController::class, 'editSarpras'])->name('admin.data-master.sarpras.edit-form');
//         Route::patch('/admin/data-master/{kode_barang}/{nup}/edit', [AsetController::class, 'update'])->name('admin.data-master.sarpras.edit');
//         Route::get('/admin/data-master/{kode_barang}/{nup}/hapus', [AsetController::class, 'remove'])->name('admin.data-master.sarpras.hapus');
//         Route::get('/admin/data-master/{kode_barang}/{nup}/detail', [AdminController::class, 'dataMasterDetail'])->name('admin.data-master.sarpras.detail');
//         Route::get('/admin/jadwal-pengecekan-kelas', [AdminController::class, 'jadwalPengecekanKelas'])->name('admin.jadwal-pengecekan-kelas');
//         Route::get('/admin/jadwal-pengecekan-kelas/view', [PengecekanKelasController::class, 'dataAdmin'])->name('admin.jadwal-pengecekan-kelas.view');
//         Route::get('/admin/jadwal-pengecekan-kelas/penugasan/{pengecekan_kelas_id}', [PengecekanKelasController::class, 'selesaikan'])->name('admin.jadwal-pengecekan-kelas.selesaikan');
//         Route::get('/admin/barang-habis-pakai', [AdminController::class, 'barangHabisPakai'])->name('admin.bhp');
//         Route::get('/admin/barang-habis-pakai/view/bhp', [BarangHabisPakaiController::class, 'dataBHP'])->name('admin.bhp.view.dataBHP');
//         Route::get('/admin/barang-habis-pakai/view/ambil-bhp', [AmbilBarangHabisPakaiController::class, 'dataAmbilBHP'])->name('admin.bhp.view.dataAmbilBHP');
//         Route::get('/admin/barang-habis-pakai/view/transaksi-bhp', [BarangHabisPakaiController::class, 'dataTransaksiBHP'])->name('admin.bhp.view.dataTransaksiBHP');
//         Route::get('/admin/barang-habis-pakai/tambah-bhp', [AdminController::class, 'tambahBHP'])->name('admin.bhp.tambah-form');
//         // Route::get('/admin/barang-habis-pakai/notifikasi', [BarangHabisPakaiController::class, 'notifikasi'])->name('admin.bhp.notifikasi');
//         Route::post('/admin/barang-habis-pakai/tambah-bhp', [BarangHabisPakaiController::class, 'store'])->name('admin.bhp.tambah');
//         Route::get('/admin/barang-habis-pakai/tambah-jenis-bhp', [AdminController::class, 'tambahJenisBHP'])->name('admin.bhp.tambah-jenis-form');
//         Route::post('/admin/barang-habis-pakai/tambah-jenis-bhp', [BarangHabisPakaiController::class, 'jenisBHP'])->name('admin.bhp.tambah-jenis-bhp');
//         Route::get('/admin/barang-habis-pakai/{pengambilan_bhp_id}/hapus-pengambilan-bhp', [AmbilBarangHabisPakaiController::class, 'hapusPengambilanBHP'])->name('admin.bhp.hapus-pengambilan-bhp');
//         Route::get('/admin/barang-habis-pakai/{id}/edit-form', [AdminController::class, 'showBhpEditForm'])->name('admin.bhp.edit-form');
//         Route::patch('/admin/barang-habis-pakai/{id}/edit', [BarangHabisPakaiController::class, 'editTransaksiBHP'])->name('admin.bhp.edit');
//         Route::get('/admin/barang-habis-pakai/{id}/hapus-transaksi-bhp', [BarangHabisPakaiController::class, 'hapusTransaksiBHP'])->name('admin.bhp.hapus-transaksi-bhp');
//         Route::get('/admin/barang-habis-pakai/{jenis_barang}/hapus-bhp', [BarangHabisPakaiController::class, 'hapusBHP'])->name('admin.bhp.hapus-bhp');
//         Route::post('/admin/barang-habis-pakai/print-pengambilan-bhp', [AmbilBarangHabisPakaiController::class, 'eksporBHP'])->name('admin.bhp.print-pengambilan-bhp');
//         Route::post('/admin/barang-habis-pakai/print-pengambilan-bhp', [AmbilBarangHabisPakaiController::class, 'eksporBHP'])->name('admin.bhp.print-pengambilan-bhp');
//         Route::get('/cetak-bhp',function(){
//            return view('export.format-bhp');
//         });
        
//         //{id} itu merupakan parameter yang dikirimkan
//     });

//     // Route untuk Koordinator
//     Route::middleware(['userAkses:Koordinator'])->group(function () {
//         Route::get('/koordinator/jadwal-pengecekan-kelas', [KoordinatorController::class, 'jadwalPengecekanKelas'])->name('koordinator.jadwal-pengecekan-kelas');
//         Route::get('/koordinator/jadwal-pengecekan-kelas/view', [PengecekanKelasController::class, 'dataKoordinator'])->name('koordinator.jadwal-pengecekan-kelas.view');
//         Route::get('/koordinator/jadwal-pengecekan-kelas/tambah', [KoordinatorController::class, 'tambahJadwal'])->name('koordinator.jadwal-pengecekan-kelas.tambah-form');
//         Route::post('/koordinator/jadwal-pengecekan-kelas/tambah-awal', [PengecekanKelasController::class, 'store'])->name('koordinator.jadwal-pengecekan-kelas.store');
//         Route::post('/koordinator/jadwal-pengecekan-kelas/tambah-baru', [PengecekanKelasController::class, 'generate'])->name('koordinator.jadwal-pengecekan-kelas.generate');
//         Route::get('/koordinator/jadwal-pengecekan-kelas/penugasan/{pengecekan_kelas_id}', [KoordinatorController::class, 'penugasan'])->name('koordinator.jadwal-pengecekan-kelas.penugasan-form');
//         Route::post('/koordinator/jadwal-pengecekan-kelas/penugasan/{pengecekan_kelas_id}', [PengecekanKelasController::class, 'tugaskanAdmin'])->name('koordinator.jadwal-pengecekan-kelas.penugasan');
//         Route::get('/koordinator/daftar-pengaduan', [KoordinatorController::class, 'daftarPengaduan'])->name('koordinator.daftar-pengaduan');
//         Route::get('/koordinator/daftar-pengaduan/view', [PengaduanController::class, 'dataKoordinator'])->name('koordinator.daftar-pengaduan.view');
//         Route::get('/koordinator/daftar-pengaduan/detail/{tiket}', [KoordinatorController::class, 'daftarPengaduanDetail'])->name('koordinator.daftar-pengaduan-detail');
//         Route::put('/koordinator/daftar-pengaduan/detail/{tiket}', [KoordinatorController::class, 'updatePengaduan'])->name('koordinator.update-pengaduan');
//         Route::post('/koordinator/daftar-pengaduan/detail/{tiket}', [KoordinatorController::class, 'tolakPengaduan'])->name('koordinator.tolak-pengaduan');
//         Route::get('/koordinator/daftar-perbaikan', [KoordinatorController::class, 'daftarPerbaikan'])->name('koordinator.daftar-perbaikan');
//         Route::get('/koordinator/daftar-perbaikan/view', [PerbaikanController::class, 'dataKoordinator'])->name('koordinator.daftar-perbaikan.view');
//         Route::get('/koordinator/daftar-perbaikan/detail/{tiket}', [KoordinatorController::class, 'daftarPerbaikanDetail'])->name('koordinator.daftar-perbaikan-detail');
//         Route::get('/koordinator/daftar-perbaikan/detail/print/{tiket}', [PerbaikanController::class, 'printPerbaikan'])->name('teknisi.daftar-perbaikan.print');
//     });

//     // Route untuk Pelapor
//     Route::middleware(['userAkses:Pelapor'])->group(function () {
//         Route::get('/pelapor/buat-pengaduan', [PelaporController::class, 'buatPengaduan']);
//         Route::post('/pelapor/buat-pengaduan', [PengaduanController::class, 'store'])->name('pelapor.data-pengaduan.store');
//         Route::get('/pelapor/daftar-pengaduan', [PelaporController::class, 'daftarPengaduan'])->name('pelapor.daftar-pengaduan');
//         Route::get('/pelapor/daftar-pengaduan/view', [PengaduanController::class, 'data'])->name('pelapor.daftar-pengaduan.view');
//         Route::get('/pelapor/daftar-pengaduan/detail/{tiket}', [PelaporController::class, 'daftarPengaduanDetail'])->name('pelapor.daftar-pengaduan-detail');
//     });

//     // Route untuk Pemakai BHP
//     Route::middleware(['userAkses:PemakaiBHP'])->group(function () {
//         Route::get('/pemakaibhp/pengambilan', [PemakaiBHPController::class, 'pengambilan'])->name('pemakaibhp.pengambilan');
//         Route::post('/pemakaibhp/pengambilan', [AmbilBarangHabisPakaiController::class, 'store'])->name('pemakaibhp.pengambilan.ambil');
//         // Route::get('/admin/barang-habis-pakai/view/AmbilBHP', [AmbilBarangHabisPakaiController::class, 'data'])->name('admin.bhp.view.ambilbhp');
//     });
// });

// //Falana
// Route::get('/teknisi/daftar-pengaduan', [TeknisiController::class, 'daftarPengaduan'])->middleware('userAkses:Teknisi');

// Route::get('/teknisi/daftar-pengaduan/detail', [TeknisiController::class, 'daftarPengaduanDetail']);

// Route::get('/admin/data-ruangan', [AdminController::class, 'dataRuangan']);

// Route::get('/admin/ketersediaan-ruangan', [AdminController::class, 'ketersediaanRuangan']);

// Route::get('/admin/ketersediaan-ruangan/detail', [AdminController::class, 'ketersediaanRuanganDetail']);

// Route::get('/admin/data-ruangan/edit-ruang', [AdminController::class, 'editRuangan']);

// Route::get('/admin/data-ruangan/tambah-ruang', [AdminController::class, 'tambahRuangan']);

// Route::get('/admin/pengelolaan-peminjaman', [AdminController::class, 'pengelolaanPeminjaman']);

// Route::get('/admin/pengelolaan-peminjaman/detail', [AdminController::class, 'pengelolaanPeminjamanDetail']);

// //Anggy
// Route::get('/admin/data-master', [AdminController::class, 'dataMaster']);

// Route::get('/admin/data-master/detail', [AdminController::class, 'dataMasterDetail']);

// Route::get('/admin/data-master/tambah-sarpras', [AdminController::class, 'tambahSarpras']);

// Route::get('/admin/data-master/edit-sarpras', [AdminController::class, 'editSarpras']);

// //Gita
// Route::get('/admin/jadwal-pengecekan-kelas', [AdminController::class, 'jadwalPengecekanKelas']);

// Route::get('/admin/barang-habis-pakai', [AdminController::class, 'barangHabisPakai']);

// Route::get('/admin/barang-habis-pakai/tambah-bhp', [AdminController::class, 'tambahBHP ']);

// Route::get('/koordinator/jadwal-pengecekan-kelas', [KoordinatorController::class, 'jadwalPengecekanKelas']);

// Route::get('/koordinator/jadwal-pengecekan-kelas/penugasan', [KoordinatorController::class, 'penugasan']);

// Route::get('/pemakaibhp/pengambilan', [PemakaiBHPController::class, 'pengambilan']);

// //Sari
// Route::get('/teknisi/jadwal-pemeliharaan', [TeknisiController::class, 'jadwalPemeliharaan']);

// Route::get('/teknisi/jadwal-pemeliharaan/pemeliharaan', [TeknisiController::class, 'pemeliharaan']);

// //Haykal
// Route::get('/teknisi/daftar-pemeliharaan', [TeknisiController::class, 'daftarPemeliharaan']);

// Route::get('/teknisi/daftar-pemeliharaan/detail', [TeknisiController::class, 'daftarPemeliharaanDetail']);

// //Sindu
// Route::get('/teknisi/daftar-pengaduan/detail/catat', [TeknisiController::class, 'perbaikan']);

// Route::get('/teknisi/daftar-perbaikan', [TeknisiController::class, 'daftarPerbaikan']);

// Route::get('/teknisi/daftar-perbaikan/detail', [TeknisiController::class, 'daftarPerbaikanDetail']);

// Route::get('/koordinator/daftar-pengaduan', [KoordinatorController::class, 'daftarPengaduan']);

// Route::get('/koordinator/daftar-pengaduan/detail', [KoordinatorController::class, 'daftarPengaduanDetail']);

// Route::get('/koordinator/daftar-perbaikan', [KoordinatorController::class, 'daftarPerbaikan']);

// Route::get('/koordinator/daftar-perbaikan/detail', [KoordinatorController::class, 'daftarPerbaikanDetail']);

// Route::get('/pelapor/buat-pengaduan', [PelaporController::class, 'buatPengaduan']);

// Route::get('/pelapor/daftar-pengaduan', [PelaporController::class, 'daftarPengaduan']);

// Route::get('/pelapor/daftar-pengaduan/detail', [PelaporController::class, 'daftarPengaduanDetail']);
