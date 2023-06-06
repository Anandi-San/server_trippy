<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\schedule;
use Illuminate\Http\Request;

class AddScheduleController extends Controller
{
    public function store (Request $request){
        $datavalid = $request->validate([
            'product_id' => 'required',
            'kota_asal' => 'required|max:255',
            'kota_tiba' => 'required|max:255',
            'tgl_pergi' => 'required|date',
            'tgl_tiba' => 'required|date',
            'waktu_pergi' => 'required',
            'waktu_tiba' => 'required',
            'amount' => 'required',
            'price' => 'required'
        ]);

        // dd($datavalid);
        schedule::create($datavalid);

        if(auth()->user()->role_id == 13){
            return response()->json(['message' => 'Jadwal berhasil ditambahkan!'], 200);
        } elseif(auth()->user()->role_id == 12){
            return response()->json(['message' => 'Jadwal berhasil ditambahkan!'], 200);
        }
    }

    public function update(Request $request, $id)
    {
        $jadwal = schedule::find($id);

        $datavalid = $request->validate([
            'product_id' => 'required',
            'kota_asal' => 'required|max:255',
            'kota_tiba' => 'required|max:255',
            'tgl_pergi' => 'required|date',
            'tgl_tiba' => 'required|date',
            'waktu_pergi' => 'required',
            'waktu_tiba' => 'required',
            'amount' => 'required|numeric',
            'price' => 'required|numeric'
        ]);

        $jadwal->kota_asal = $datavalid['kota_asal'];
        $jadwal->kota_tiba = $datavalid['kota_tiba'];
        $jadwal->tgl_pergi = $datavalid['tgl_pergi'];
        $jadwal->tgl_tiba = $datavalid['tgl_tiba'];
        $jadwal->waktu_pergi = $datavalid['waktu_pergi'];
        $jadwal->waktu_tiba = $datavalid['waktu_tiba'];
        $jadwal->amount = $datavalid['amount'];
        $jadwal->price = $datavalid['price'];

        $jadwal->save();

        if(auth()->user()->role_id == 1){
            // return redirect('/tabel_pesawat')->with('success', 'jadwal berhasil diubah!');
            return response()->json(['message' => 'Jadwal berhasil diubah!'], 200);
        } 
        elseif(auth()->user()->role_id == 2){
            // return redirect('/halaman_mitra')->with('success', 'jadwal berhasil diubah!');
            return response()->json(['message' => 'Jadwal berhasil diubah!'], 200);
        }
    }

    public function destroy($id)
    {
        $jadwal = schedule::find($id);
        $jadwal->delete();

        if(auth()->user()->role_id == 1){
            // return redirect('/tabel_pesawat')->with('deleted', 'jadwal berhasil dihapus!');
            return response()->json(['message' => 'Jadwal berhasil dihapus!'], 200);
        } 
        elseif(auth()->user()->role_id == 2){
            // return redirect('/halaman_mitra')->with('deleted', 'jadwal berhasil dihapus!');
            return response()->json(['message' => 'Jadwal berhasil dihapus!'], 200);
        }
    }
}