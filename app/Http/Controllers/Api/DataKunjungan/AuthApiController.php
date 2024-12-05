<?php

namespace App\Http\Controllers\Api\DataKunjungan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class AuthApiController extends Controller
{
    /**
     * Login API untuk mendapatkan token dengan role berdasarkan pengguna
     */
    public function login(Request $request)
    {
        // Validasi input dari user
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // Cek apakah user ada dan passwordnya sesuai
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Generate token untuk user
        $token = $user->createToken('AppToken')->accessToken;

        // Cek role pengguna dan berikan respons sesuai role
        if ($user->hasRole('admin')) {
            return response()->json([
                'message' => 'Admin Dashboard',
                'token' => $token
            ], 200);
        } elseif ($user->hasRole('wisata')) {
            return response()->json([
                'message' => 'Wisata Dashboard',
                 'token' => $token
            ], 200);
        } elseif ($user->hasRole('kuliner')) {
            return response()->json([
                'message' => 'Kuliner Dashboard',
                 'token' => $token
            ], 200);
        } elseif ($user->hasRole('akomodasi')) {
            return response()->json([
                'message' => 'Akomodasi Dashboard',
                 'token' => $token
            ], 200);
        } else {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
    }

    /**
     * Logout API   
     */
    public function logout(Request $request)
    {
        // Mendapatkan pengguna yang sedang login
        $user = Auth::user();

        // Revoke semua token milik pengguna
        $user->tokens->each(function ($token) {
            $token->delete();
        });

        return response()->json(['message' => 'Successfully logged out'], 200);
    }
}
