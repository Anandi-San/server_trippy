<?php

use App\Http\Controllers\api\AddHotelController;
use App\Http\Controllers\api\AddScheduleController;
use App\Http\Controllers\api\BookingAirplaneController;
use App\Http\Controllers\api\BookingController;
use App\Http\Controllers\api\BookingHotelController;
use App\Http\Controllers\api\EwalletController;
use App\Http\Controllers\api\LandingPageController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\SesionController;
use App\Http\Controllers\api\TransaksiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;


// user
// Route::get('/user', [App\Http\Controllers\api\UserController::class, 'index']);
// route user
Route::get('/user', [UserController::class, 'index']);
Route::post('/user', [UserController::class, 'store']);
Route::delete('/user/{id}', [UserController::class, 'destroy']);
Route::patch('/user/{id}', [UserController::class, 'update']);



// Route::get('/product', [ProductController::class, 'index']);

// PUNYA ADMIN //
Route::group(['middleware' => 'isAdmin'], function () {

    // ke dashbord admin
    Route::get('/dashboard_admin', [LandingPageController::class, 'dashboard_admin']);
    // ke pengaturan akun di dashboard admin
    Route::get('/pengaturan_akun', [LandingPageController::class, 'akun']);

    Route::get('/pengaturan_hotelpesawat', [LandingPageController::class, 'pengaturan']);
    // table pengguna
    Route::get('/tabel_pengguna', [LandingPageController::class, 'tabel_pengguna']);

    Route::post('/hapus_hotelpesawat', [ProductController::class, 'destroy']);

    Route::resource('/daftar_akun', UserController::class);

    Route::get('/isi_uang_elektronik', [LandingPageController::class, 'isi_uang_elektronik']);
    // Route::get('/search', [LandingPageController::class, 'search'])->name('search');
    Route::post('/add-saldo', [TransaksiController::class, 'addSaldo'])->name('add-saldo');

    Route::resource('/ewallet', EwalletController::class);

    Route::get('/tabel_mitra', [LandingPageController::class, 'tabel_mitra']);
    Route::get('/tabel_hotel', [LandingPageController::class, 'tabel_hotel']);
    Route::get('/tabel_pesawat', [LandingPageController::class, 'tabel_pesawat']);
    Route::get('/form_tambah_hotelpesawat', [ProductController::class, 'index']);
    Route::get('/tarik_uang_elektronik', [LandingPageController::class, 'tarik_uang_elektronik']);
    Route::get('/pengaturan_hotel_pesawat', [LandingPageController::class, 'hotelpesawat']);
});


// punya pengguna atau admin
Route::group(['Middleware' => 'checkUserAdmin'], function () {
    Route::resource('/hotel', BookingHotelController::class);
    Route::resource('/pesawat', BookingAirplaneController::class);

    Route::get('/pesanan_saya', [LandingPageController::class, 'pesanan']);
    Route::get('/booking_hotel', [LandingPageController::class, 'pengguna_book_hotel']);
    Route::get('/booking_pesawat', [LandingPageController::class, 'pengguna_book_plane']);
    Route::get('/pesawat_search', [LandingPageController::class, 'pesawat']);
    Route::get('/booking_hotel/{id}', [LandingPageController::class, 'booking_hotel'])->name('booking.detail');
    Route::get('/booking_plane/{id}', [LandingPageController::class, 'booking_plane'])->name('bookingP.detail');
    Route::get('/pesanan/{id}', [BookingController::class, 'pembatalan'])->name('pesanan.detail');
});

Route::group(['middleware' => 'mitraAdmin'], function () {

    Route::get('/halaman_mitra', [LandingPageController::class, 'halaman_mitra']);

// PUNYA MITRA & ADMIN //
    Route::resource('/produk', ProductController::class);
    Route::resource('/jadwal', AddScheduleController::class);
    Route::resource('/kamar', AddHotelController::class);

    Route::get('/form_tambah_jadwal/{id}', [LandingPageController::class, 'jadwals']);
    Route::get('/form_tambah_kamar/{id}', [LandingPageController::class, 'kamars']);
});

// SESION Aman
Route::get('/', [SessionController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [SesionController::class, 'login']);
Route::get('/logout', [SessionController::class, 'logout']);




// mitra

// admin