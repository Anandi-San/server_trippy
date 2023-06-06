<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\history_transaction;
use App\Models\transaction;
use App\Models\User;
use Illuminate\Http\Request;

class EwalletController extends Controller
{
    public function index(Request $request)
    {
        $username = $request->input('username');

        $saldo = User::with('transaksi')->get();
        $data = transaction::filter(['username' => $username])->get();

        return response()->json([
            'message' => 'success',
            'saldo' => $saldo,
            'data' => $data
        ], 200);
    }

    public function store(Request $request)
    {

        // dd($request['id'],$request['debit']);

        // tambah data
        $transaksi = new history_transaction();
        $transaksi->user_id = $request['id'];
        $transaksi->debit = $request['debit'] ? $request['debit'] : 0;
        $transaksi->kredit = $request['kredit'] ? $request['kredit'] : 0;
        $transaksi->keterangan = 'Perubahan saldo';
        $transaksi->save();

        // update transaksi
        if(isset($request['debit'])){
            $ewallet = transaction::where('user_id',$request['id'])->first();
            $ewallet->update(['saldo_awal' => $ewallet->saldo_akhir]);
            $saldo_akhir = $ewallet->saldo_akhir + $request['debit'];
            $ewallet->update(['saldo_akhir' => $saldo_akhir]);
            $ewallet->update(['debit' => $request['debit']]);
            $ewallet->update(['kredit' => 0]);
            $ewallet->update(['keterangan' => 'Top Up saldo']);

        } elseif(isset($request['kredit'])){
            $ewallet = transaction::where('user_id',$request['id'])->first();
            $ewallet->update(['saldo_awal' => $ewallet->saldo_akhir]);
            $saldo_akhir = $ewallet->saldo_akhir - $request['kredit'];
            $ewallet->update(['saldo_akhir' => $saldo_akhir]);
            $ewallet->update(['debit' => 0]);
            $ewallet->update(['kredit' => $request['kredit']]);
            $ewallet->update(['keterangan' => 'Penarikan saldo']);
        }
        
        return response()->json(['message' => 'Saldo berhasil ditambahkan'], 200);
    }
}
