<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\JenisController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\PegawaiController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\ReturanController;
use App\Http\Controllers\Api\BarangController;
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

    Route::get('/customer', [CustomerController::class, 'index']);
    Route::post('/customer', [CustomerController::class, 'store']);
    Route::get('/customer/{id_customer}', [CustomerController::class, 'show']);
    Route::delete('/customer/{id_customer}', [CustomerController::class, 'destroy']);
    Route::put('/customer/{id_customer}', [CustomerController::class, 'update']);

    Route::get('/pegawai', [PegawaiController::class, 'index']);
    Route::post('/pegawai', [PegawaiController::class, 'store']);
    Route::get('/pegawai/{id_pegawai}', [PegawaiController::class, 'show']);
    Route::delete('/pegawai/{id_pegawai}', [PegawaiController::class, 'destroy']);
    Route::put('/pegawai/{id_pegawai}', [PegawaiController::class, 'update']);

    Route::get('/supplier', [SupplierController::class, 'index']);
    Route::post('/supplier', [SupplierController::class, 'store']);
    Route::get('/supplier/{id_supplier}', [SupplierController::class, 'show']);
    Route::delete('/supplier/{id_supplier}', [SupplierController::class, 'destroy']);
    Route::put('/supplier/{id_supplier}', [SupplierController::class, 'update']);

    Route::get('/returan', [ReturanController::class, 'index']);
    Route::post('/returan', [ReturanController::class, 'store']);
    Route::get('/returan/{id_returan}', [ReturanController::class, 'show']);
    Route::delete('/returan/{id_returan}', [ReturanController::class, 'destroy']);
    Route::put('/returan/{id_returan}', [ReturanController::class, 'update']);

    Route::get('/barang', [BarangController::class, 'index']);
    Route::post('/barang', [BarangController::class, 'store']);
    Route::get('/barang/{id_barang}', [BarangController::class, 'show']);
    Route::delete('/barang/{id_barang}', [BarangController::class, 'destroy']);
    Route::put('/barang/{id_barang}', [BarangController::class, 'update']);

    //kurang transaksi(idbarang,idcustomer,idpegawai) dan pengiriman(idbarang dan idsupplier)
    //tambahan untuk beberapa laporan
    
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
