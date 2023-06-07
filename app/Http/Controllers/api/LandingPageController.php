<?php

namespace App\Http\Controllers\api;


use App\Http\Controllers\Controller;
use App\Models\product;
use App\Models\room;
use App\Models\schedule;
use App\Models\User;
use App\Models\booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LandingPageController extends Controller
{
    function dashboard_admin(){
        $countUsers = DB::table('users')->where('role_id', '=', 12)->count();
        $countMitra = DB::table('users')->where('role_id', '=', 12)->count();
        $countPesawat = DB::table('products')->where('types_id', '=', 5)->count();
        $countHotel = DB::table('products')->where('types_id', '=', 6)->count();

        return response()->json([
            'message' => 'success',
            'data' => [
                'countUsers' => $countUsers,
                'countMitra' => $countMitra,
                'countPesawat' => $countPesawat,
                'countHotel' => $countHotel
            ]
        ], 200);
    }

    function akun(){
        $data = User::with('role')->get();

        return response()->json([
            'message' => 'success',
            'data' => $data
        ], 200);
    }

    function tabel_pengguna(){
        $data = User::with('role','transaction')
            ->where('Users.role_id','=',3)
            ->get();

        return response()->json([
            'message' => 'success',
            'data' => $data
        ], 200);
    }


    function hotelpesawat(){
        $data = product::with('types', 'user')
                ->orderBy('types_id')
                ->orderBy('name_product')
                ->get();
        return response()->json([
            'message' => 'success',
            'data' => $data
        ], 200);
    }

    function isi_uang_elektronik(){
        return response()->json([
            'message' => 'success',
            'data' => 'Halaman isi uang elektronik'
        ], 200);
    }

    // function search(Request $request)
    // {
    //     $username = $request->input('username');
    //     $hasilPencarian = User::where('name', 'like', "%$username%")->get();

    //     return view('halaman/admin/isi_uang_elektronik', compact('hasilPencarian'));
    // }

    function tarik_uang_elektronik(){
        return response()->json([
            'message' => 'success',
            'data' => 'Halaman tarik uang elektronik'
        ], 200);
    }

    function halaman_mitra(){
        $jadwal = schedule::all();
        $kamar = room::all();
        $user = User::with('transaction')->get();
        $produk = product::with('types','user')
                  ->where('products.user_id','=',auth()->user()->id)
                  ->orderBy('types_id')
                  ->orderBy('name_product')
                  ->get();

                //   ubah ke json sih ini
        return response()->json([
            'message' => 'success',
            'data' => [
                'product' => $produk,
                'user' => $user,
                'schedule' => $jadwal,
                'room' => $kamar
            ]
        ], 200);
    }

    function pengguna_book_hotel(){
        $data = User::with('transaction')->get();

        $produk = product::with('type')
        ->where('products.type_id','=', 6)
        ->get();

        // ubah json juga
    return response()->json([
        'message' => 'success',
        'data' => [
            'users' => $data,
            'product' => $produk
        ]
    ], 200);
    }

    function pengguna_book_plane(){
        $data = User::with('transaction')->get();

        $produk = schedule::with('product')->get();

        // json
        return response()->json([
            'message' => 'success',
            'data' => [
                'users' => $data,
                'product' => $produk
            ]
        ], 200);
    }

    function pesawat(){
        $data = User::with('transaction')->get();
        $produk = schedule::with('product')->get();

        // json
        return response()->json([
            'message' => 'success',
            'data' => [
                'users' => $data,
                'product' => $produk
            ]
        ], 200);
    }

    function hotel(){
        $data = user::with('transaction')->get();

        $produk = product::with('type')
        ->where('products.types_id','=', 6)
        ->get();

        // json
        return response()->json([
            'message' => 'success',
            'data' => [
                'users' => $data,
                'product' => $produk
            ]
        ], 200);
    }

    function booking_hotel($id){
        $data = room::with('product')
            ->where('id','=',$id)
            ->get();

            // json
        return response()->json([
            'message' => 'success',
            'data' => $data
        ], 200);
    }

    function booking_plane($id){
        $data = schedule::with('product')
            ->where('id','=',$id)
            ->get();
        return response()->json([
            'message' => 'success',
            'data' => $data
        ], 200);
    }

    function pesanan(){
        $data1 = booking::with('room')
            ->where('user_id', Auth::user()->id)
            ->get();

        $data2 = booking::with('schedule')
            ->where('user_id', Auth::user()->id)
            ->get();

            // json
        return response()->json([
            'message' => 'success',
            'data1' => $data1,
            'data2' => $data2
        ], 200);
    }

    function scheduless($id){
        $data = product::where('id','=',$id)
            ->get();
        
            // json
        return response()->json([
            'message' => 'success',
            'data' => $data
        ], 200);
    }

    function rooms($id){
        $data = product::where('id','=',$id)
            ->get();

            // json
        return response()->json([
            'message' => 'success',
            'data' => $data
        ], 200);
    }

    function dashboard(){
        return response()->json([
            'message' => 'success',
            'data' => 'dashboard data'
        ], 200);
    }

    function tabel_mitra(){
        $data = User::with('role','transaction')
            ->where('Users.role_id','=',13)
            ->get();
        // json
        return response()->json([
            'message' => 'success',
            'data' => $data
        ], 200);
    }

    function tabel_hotel(){
        $data = product::orderBy('name_product')->get();
        $kamar = room::with('product')->get();

        // json
        return response()->json([
            'message' => 'success',
            'data' => $data,
            'room' => $kamar
        ], 200);
    }
    function tabel_pesawat(){
        $data = product::orderBy('name_product')->get();
        $jadwal = schedule::with('produk')->get();

        // json
        return response()->json([
            'message' => 'success',
            'data' => $data,
            'schedule' => $jadwal
        ], 200);
     }
}