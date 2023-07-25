<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AbsensiControlller;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KonfigurasiController;

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
Route::group(['middleware' => ['guest:karyawan']], function(){
    Route::get('/', [AuthController::class, 'showFormLogin'])->name('login');
    Route::post('/proseslogin', [AuthController::class, 'proseslogin']);
});

Route::group(['middleware' => ['guest:user']], function(){
    Route::get('/panel', [AuthController::class, 'showLoginAdmin'])->name('loginadmin');
    Route::post('/prosesloginadmin', [AuthController::class, 'prosesloginadmin']);
});

Route::group(['middleware' => ['auth:karyawan']], function(){
    Route::get('/dashboard', [DashboardController::class, 'dashboard']);
    Route::get('/logout', [AuthController::class, 'logout']);

    //Absensi
    Route::get('/absensi/create', [AbsensiControlller::class, 'create']);
    Route::post('/absensi/store', [AbsensiControlller::class, 'store']);

    //EditProfile
    Route::get('/editprofile', [AbsensiControlller::class, 'editprofile']);
    Route::post('/absensi/{nik}/updateprofile', [AbsensiControlller::class, 'updateprofile']);

    //Histori
    Route::get('/absensi/histori', [AbsensiControlller::class, 'histori']);
    Route::post('/absensi/gethistori', [AbsensiControlller::class, 'gethistori']);

    //Izin
    Route::get('/absensi/izin', [AbsensiControlller::class, 'izin']);
    Route::get('/absensi/buatizin', [AbsensiControlller::class, 'buatizin']);
    Route::post('/absensi/cektanggal', [AbsensiControlller::class, 'cektanggal']);
    Route::post('/absensi/storeizin', [AbsensiControlller::class, 'storeizin']);
    Route::get('/absensi/editizin/{tgl_izin}', [AbsensiControlller::class, 'editizin']);
    Route::post('/absensi/updateizin', [AbsensiControlller::class, 'updateizin']);
});

Route::group(['middleware' => ['auth:user']], function(){
    Route::get('/panel/dashboardadmin', [DashboardController::class, 'dashboardadmin']);
    Route::get('/logoutadmin', [AuthController::class, 'logoutadmin']);

    //Karyawan
    Route::get('/karyawan', [KaryawanController::class, 'index']);
    Route::post('/karyawan/store', [KaryawanController::class, 'store']);
    Route::post('/karyawan/edit', [KaryawanController::class, 'edit']);
    Route::post('/karyawan/{nik}/delete', [KaryawanController::class, 'delete']);
    Route::post('/karyawan/{nik}/update', [KaryawanController::class, 'update']);

    //Absensi
    Route::get('/absensi/monitoring', [AbsensiControlller::class, 'monitoring']);
    Route::post('/getabsensi', [AbsensiControlller::class, 'getabsensi']);
    Route::get('/absensi/laporan', [AbsensiControlller::class, 'laporan']);
    Route::post('/absensi/cetaklaporan', [AbsensiControlller::class, 'cetaklaporan']);
    Route::get('/absensi/rekap', [AbsensiControlller::class, 'rekap']);
    Route::post('/absensi/cetakrekap', [AbsensiControlller::class, 'cetakrekap']);
    Route::get('/absensi/izinsakit', [AbsensiControlller::class, 'izinsakit']);
    
    //Konfigurasi
    Route::get('/konfigurasi/lokasikantor', [KonfigurasiController::class, 'lokasikantor']);
    Route::post('/konfigurasi/updatelokasikantor', [KonfigurasiController::class, 'updatelokasikantor']);
});

