<?php

use App\Http\Controllers\GoogleSheetController;
use Illuminate\Http\Request;
use App\Models\PeminjamanRuangan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RuangController;
use App\Http\Controllers\PeminjamanRuanganController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('peminjaman-ruangan/store', [PeminjamanRuanganController::class, 'store']);

Route::get('ruangs', [RuangController::class, 'getRuangs']);

Route::get('ketersediaan-ruangs', [GoogleSheetController::class,'readSheet']);