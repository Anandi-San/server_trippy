<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\transaction;
use App\Models\User;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index(){
        $transactions = Transaction::with('user')->get();

    return response()->json([
        'message' => 'success',
        'data' => $transactions
    ], 200);
    }

    public function addSaldo(Request $request)
    {
        $user = $request->user(); // Mengambil data user dari request

        $saldoTambah = $request->input('saldo');

        $transaksi = new transaction();
        $transaksi->user_id = $user->id;
        $transaksi->saldo_akhir = $user->saldo_akhir + $saldoTambah;
        $transaksi->keterangan = 'Penambahan saldo'; // Atur nilai keterangan sesuai kebutuhan
        $transaksi->save();

        $updatedUser = User::find($user->id);

        return response()->json([
            'message'   => 'success',
            'data'      => $updatedUser
        ],200);
        // return redirect()->back()->with('success', 'Saldo berhasil ditambahkan.');
    }
}
