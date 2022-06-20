<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\JenisController;
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
    Route::get('/jenis', [JenisController::class, 'index']);
    Route::post('/jenis', [JenisController::class, 'store']);
    Route::get('/jenis/{id_jenis}', [JenisController::class, 'show']);
    Route::delete('/jenis/{id_jenis}', [JenisController::class, 'destroy']);
    Route::put('/jenis/{id_jenis}', [JenisController::class, 'update']);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
