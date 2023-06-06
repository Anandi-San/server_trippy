<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\room;
use App\Models\User;
use Illuminate\Http\Request;

class BookingHotelController extends Controller
{
    public function index()
    {
        // return view("halaman/pengguna/hotel",[])
        return response()->json([
            'message'   => 'success',
            'data' => User::with('transaksi')->get(),
            'product' => room::filter(request(['check_in','decription']))->get()
        ],200);
    }
}