<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\schedule;
use App\Models\User;
use App\Models\transaction;
use Illuminate\Http\Request;

class BookingAirplaneController extends Controller
{
    public function index(){
        // return view("halaman/pengguna/pesawat",[
            
            return response()->json([
                'message'   => 'success',
                'data' => user::with('transaction')->get(),
                'produk' => schedule::filter(request(['check_in','kota_asal', 'kota_tujuan']))->get(),
            ],200);
        // ]);
    }
}