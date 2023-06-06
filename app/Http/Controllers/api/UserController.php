<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReplyResource;
use App\Models\role;
use App\Models\transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    // tampilkan data dari database
    public function index()
    {
        return response()->json([
            'message'   => 'success',
            // roles ya masih belum dapat
            'data'      => User::all()
        ],200);
    }

    // create Data
    public function store(Request $request)
    {
        $datavalid = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required',
            'role_id' => 'required'
        ]);

        $datavalid['password'] = bcrypt($datavalid['password']);

        DB::transaction(function () use ($datavalid) {
            // Tambah data pada tabel pertama
            $users = User::create($datavalid);

            // Tambah data pada tabel kedua
            $wallet = new transaction;
            $wallet->user_id = $users->id;
            $wallet->saldo_awal = 0;
            $wallet->debit = 0;
            $wallet->kredit = 0;
            $wallet->saldo_akhir = 0;
            $wallet->keterangan = 'akun baru';
            $wallet->save();

        });

        // return redirect('/daftar_akun')->with('success', 'akun berhasil ditambahkan!');
    }

    // menampilkan data
    // public function show(User $users)
    // {
    //     //return single post as a resource
    //     return new ReplyResource(true, 'Data User Ditemukan!', $users);
    // }


    // update data
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|max:255',
            'role_id' => 'required'
        ];

        $user = User::find($id);

        if($request->email != $user->email) {
            $rules['email'] = 'required|email:dns|unique:users';
        }

        $datavalid = $request->validate($rules);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->save();
    }

    // menghapus data
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
    }

}
