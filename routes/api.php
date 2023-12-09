<?php

use App\Http\Controllers\GoogleSheetController;
use App\Http\Controllers\RuangController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('ketersediaan-ruangs', [GoogleSheetController::class, 'getKetersediaanRuangs']);
Route::post('ketersediaan-ruangs-pertanggal/{hariBulanTahun}/{waktu}', [GoogleSheetController::class, 'getKetersediaanRuangsPerTanggal']);
Route::post('ketersediaan-ruangs/setToUnavailablePerHari', [GoogleSheetController::class, 'setToUnavailablePerHari']);
Route::post('ketersediaan-ruangs/setToUnavailable', [GoogleSheetController::class, 'setToUnavailable']);
Route::get('ruangs', [RuangController::class, 'getRuangs']);
Route::post('coba', function(){
    $response = [
        'status_code' => 200,
        'message' => 'Berhasil!',
    ];

    return response()->json($response, 200);
});