<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\IclockController;

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

Route::resource('api-karyawan', App\Http\Controllers\Api\KaryawanController::class);
Route::resource('absensi', App\Http\Controllers\Api\AbsenController::class);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// handshake
Route::get('/iclock/cdata', [iclockController::class, 'handshake']);

Route::post('/iclock/cdata', [IclockController::class, 'receiveRecords']);
