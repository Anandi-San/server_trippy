<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class SessionController extends Controller
{
    // function index(){
    //     return view('sesi/index');
    // }
    public function login(Request $request)
    {
    try {
        $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required'
        ], [
            'email.required' => 'Email Wajib Diisi!',
            'password.required' => 'Password Wajib Diisi!'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (auth()->user()->role_id == 13) {
                return response()->json([
                    'message' => 'success',
                    'redirect' => 'dashboard_admin'
                ], Response::HTTP_OK);
            } elseif (auth()->user()->role_id == 14) {
                return response()->json([
                    'message' => 'success',
                    'redirect' => 'halaman_mitra'
                ], Response::HTTP_OK);
            } elseif (auth()->user()->role_id == 15) {
                return response()->json([
                    'message' => 'success',
                    'redirect' => 'dashboard'
                ], Response::HTTP_OK);
            }
        } else {
            throw ValidationException::withMessages([
                'loginError' => 'Email atau Password tidak valid'
            ]);
        }
    } catch (ValidationException $e) {
        return response()->json([
            'message' => 'error',
            'errors' => $e->errors()
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}

    function logout(){
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return response()->json([
            'message' => 'success',
            'data' => null
        ], 200);
        // return redirect('/')->with('success', 'Berhasil Logout');
    }
}
