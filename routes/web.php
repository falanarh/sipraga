<?php

use Illuminate\Support\Facades\Route;

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
//Falana
Route::get('/teknisi/daftar-pengaduan', function () {
    return view('roles.teknisi.daftar-pengaduan-teknisi');
});

Route::get('/teknisi/daftar-pengaduan/detail', function () {
    return view('roles.teknisi.daftar-pengaduan-detail-teknisi');
});

Route::get('/teknisi/daftar-pengaduan/pencatatan-perbaikan', function () {
    return view('roles.teknisi.pencatatan-perbaikan-teknisi');
});

Route::get('/admin/data-ruangan', function () {
    return view('roles.admin.data-ruangan-admin');
});

Route::get('/admin/ketersediaan-ruangan', function () {
    return view('roles.admin.ketersediaan-ruangan-admin');
});

Route::get('/admin/ketersediaan-ruangan/detail', function () {
    return view('roles.admin.ketersediaan-ruangan-detail-admin');
});

Route::get('/admin/pengelolaan-peminjaman', function () {
    return view('roles.admin.pengelolaan-peminjaman-admin');
});

Route::get('/admin/data-ruangan/edit-ruang', function () {
    return view('roles.admin.edit-ruangan-admin');
});

Route::get('/admin/pengelolaan-peminjaman/detail', function () {
    return view('roles.admin.pengelolaan-peminjaman-detail-admin');
});

Route::get('/admin/data-ruangan/tambah-ruang', function () {
    return view('roles.admin.tambah-ruangan-admin');
});

//Anggy
Route::get('/admin/data-master', function () {
    return view('roles.admin.data-master-admin');
});

Route::get('/admin/data-master/tambah-sarpras', function () {
    return view('roles.admin.tambah-sarpras-admin');
});

Route::get('/admin/data-master/edit-sarpras', function () {
    return view('roles.admin.edit-sarpras-admin');
});

Route::get('/admin/data-master/detail', function () {
    return view('roles.admin.data-master-detail-admin');
});

//Gita
Route::get('/admin/jadwal-pengecekan-kelas', function () {
    return view('roles.admin.jadwal-pengecekan-kelas-admin');
});

Route::get('/admin/barang-habis-pakai', function () {
    return view('roles.admin.barang-habis-pakai-admin');
});

Route::get('/admin/barang-habis-pakai/tambah-bhp', function () {
    return view('roles.admin.tambah-bhp-admin');
});

Route::get('/koordinator/jadwal-pengecekan-kelas', function () {
    return view('roles.koordinator.jadwal-pengecekan-kelas-koordinator');
});

Route::get('/koordinator/jadwal-pengecekan-kelas/penugasan', function () {
    return view('roles.koordinator.penugasan-admin');
});

Route::get('/pemakaibhp/pengambilan', function () {
    return view('roles.pemakaibhp.pengambilan-pemakaibhp');
});

//Sari
Route::get('/teknisi/jadwal-pemeliharaan', function () {
    return view('roles.teknisi.jadwal-pemeliharaan-teknisi');
});

Route::get('/teknisi/jadwal-pemeliharaan/pemeliharaan', function () {
    return view('roles.teknisi.pemeliharaan-teknisi');
});