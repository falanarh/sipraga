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

Route::get('/dashboard', function () {
    return view('layouts.dashboard');
});

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


