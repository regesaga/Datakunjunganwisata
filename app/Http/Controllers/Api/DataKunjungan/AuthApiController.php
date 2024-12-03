<?php

namespace App\Http\Controllers\Api\DataKunjungan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Validator;


class AuthApiController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
    
        $user = User::where('email', $request->email)->first();
    
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    
        // Generate API token
        $token = $user->createToken('AppName')->accessToken;
    
        // Menentukan role untuk menampilkan pesan berbeda berdasarkan role
        $role = $user->getRoleNames()->first(); // Mendapatkan role pertama yang dimiliki user
    
        return response()->json([
            'message' => "Welcome, you are logged in as $role",
            'token' => $token,
            'role' => $role,
        ]);
    }
    
}
