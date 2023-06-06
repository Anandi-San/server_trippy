<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\room;
use Illuminate\Http\Request;

class AddHotelController extends Controller
{
    public function store(Request $request)
    {
        $datavalid = $request->validate([
            'product_id' => 'required',
            'price' => 'required',
            'check_in' => 'required',
            'amount' => 'required'
        ]);

        room::create($datavalid);
        if(auth()->user()->role_id == 13){
            // return redirect('/tabel_hotel')->with('success', 'kamar berhasil ditambahkan!');
            return response()->json(['message' => 'Kamar berhasil ditambahkan!'], 200);
        } 
        elseif(auth()->user()->role_id == 12){
            // return redirect('/halaman_mitra')->with('success', 'kamar berhasil ditambahkan!');
            return response()->json(['message' => 'Kamar berhasil ditambahkan!'], 200);
        }
    }

    public function update(Request $request, $id)
    {
        $kamar = room::find($id);
        $datavalid = $request->validate([
            'price' => 'required|numeric',
            'check_in' => 'required',
            'amount' => 'required|numeric'
        ]);

        $kamar->check_in = $datavalid['check_in'];
        $kamar->harga = $datavalid['harga'];
        $kamar->jumlah = $datavalid['jumlah'];

        $kamar->save();

        if(auth()->user()->role_id == 13){
            // return redirect('/tabel_hotel')->with('success', 'kamar berhasil diubah!');
            return response()->json(['message' => 'Kamar berhasil diubah!'], 200);
        } 
        elseif(auth()->user()->role_id == 12){
            // return redirect('/halaman_mitra')->with('success', 'kamar berhasil diubah!');
            return response()->json(['message' => 'Kamar berhasil diubah!'], 200);
        }
    }

    public function destroy($id)
    {
        // dd($id);
        $kamar = room::find($id);
        $kamar->delete();

        if(auth()->user()->role_id == 13){
            // return redirect('/tabel_hotel')->with('deleted', 'kamar berhasil dihapus!');
            return response()->json(['message' => 'Kamar berhasil dihapus!'], 200);
        } elseif(auth()->user()->role_id == 12){
            // return redirect('/halaman_mitra')->with('deleted', 'kamar berhasil dihapus!');
            return response()->json(['message' => 'Kamar berhasil dihapus!'], 200);
        }
    }
}
