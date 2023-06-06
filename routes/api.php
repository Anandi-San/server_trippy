<?php

use App\Http\Controllers\api\BookingAirplaneController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;


// user
// Route::get('/user', [App\Http\Controllers\api\UserController::class, 'index']);
Route::get('/user', [UserController::class, 'index']);
Route::post('/user', [UserController::class, 'store']);
Route::get('/product', [ProductController::class, 'index']);
Route::get('/bookingAirplane', [BookingAirplaneController::class, 'index']);

// Route::get('/bookingroom', [App\Http\Controllers\api\BookingRoomController::class, 'index']);
// Route::post('/login', [SessionController::class, 'login']);
// Route::get('/logout', [SessionController::class, 'logout']);




// mitra

// admin