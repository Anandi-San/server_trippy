<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\booking;
use App\Models\history_transaction;
use App\Models\room;
use App\Models\schedule;
use App\Models\transaction;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function cancel($id)
    {
        $booking = booking::with('room', 'schedule')
            ->find($id);

        if (!empty($booking->room->check_in)) {
            if (Carbon::parse($booking->room->check_in)->between(Carbon::now(), Carbon::now()->addDays(2))) {
                // Menampilkan popup atau pesan error
                // return redirect('/pesanan_saya')->with('error', 'Maaf! Pesanan Tidak Dapat Dibatalkan, Lakukan Pembatalan Minimal H-2');
                return response()->json(['error' => 'Maaf! Pesanan Tidak Dapat Dibatalkan, Lakukan Pembatalan Minimal H-2'], 400);
            }
        } elseif (!empty($booking->schedule->tgl_pergi)) {
            if (Carbon::parse($booking->schedule->tgl_pergi)->between(Carbon::now(), Carbon::now()->addDays(2))) {
                // Menampilkan popup atau pesan error
                // return redirect('/pesanan_saya')->with('error', 'Maaf! Pesanan Tidak Dapat Dibatalkan, Lakukan Pembatalan Minimal H-2');
                return response()->json(['error' => 'Maaf! Pesanan Tidak Dapat Dibatalkan, Lakukan Pembatalan Minimal H-2'], 400);
            }
        }

        $booking->status = 'dibatalkan';
        $booking->save();

        $transaksi = new history_transaction();
        $transaksi->user_id = auth()->user()->id;
        $transaksi->debit = $booking->total_harga;
        $transaksi->kredit = 0;
        $transaksi->keterangan = 'pembatalan pesanan';

        $transaksi->save();

        $ewallet = transaction::where('user_id', auth()->user()->id)->first();
        $ewallet->update(['saldo_awal' => $ewallet->saldo_akhir]);
        $saldo_akhir = $ewallet->saldo_akhir + $booking->total_harga;
        $ewallet->update(['saldo_akhir' => $saldo_akhir]);
        $ewallet->update(['debit' => $booking->total_harga]);
        $ewallet->update(['kredit' => 0]);
        $ewallet->update(['keterangan' => 'pembatalan pesanan']);

        if (!empty($booking->room_id)) {
            $kamar = room::where('id', $booking->room_id)->first();
            $jml = $kamar->amount + intval($booking->qty);
            $kamar->update(['amount' => $jml]);
        } elseif (!empty($booking->schedule_id)) {
            $jadwal = schedule::where('id', $booking->schedule_id)->first();
            $jml = $jadwal->amount + intval($booking->qty);
            $jadwal->update(['amount' => $jml]);
        }

        return response()->json(['message' => 'Pesanan berhasil dibatalkan'], 200);
    }
}