<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AddMitraController extends Controller
{
    public function index(){
        $users = User::whereHas('role', function ($query) {
            $query->where('role', 'mitra');
        })->get();
    
        return response()->json([
            'message' => 'success',
            'data' => $users
        ], 200);
    }

    public function store(Request $request)
    {
        // return request()->all();
        $datavalid = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required'
        ]);

        $datavalid['password'] = bcrypt($datavalid['password']);
        // $datavalid['role'] = 

        User::create($datavalid);
        $request->session()->flash('success', 'Data Berhasil Ditambahkan!');
        // return redirect('/tabel_mitra');
        return response()->json(['message' => 'Data berhasil ditambahkan!'], 200);
    }
}
