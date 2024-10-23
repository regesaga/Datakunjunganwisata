<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wisatawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        // Google user object dari google
        $userFromGoogle = Socialite::driver('google')->user();
    
        // Ambil user dari database berdasarkan google user id
        $userFromDatabase = Wisatawan::where('google_id', $userFromGoogle->id)->first();
        // Jika tidak ada user, maka buat user baru
        if (!$userFromDatabase) {
            $userFromDatabase = Wisatawan::where('email', $userFromGoogle->email)->first();
    
            if (!$userFromDatabase) {
                $newUser = new Wisatawan([
                    'google_id' => $userFromGoogle->getId(),
                    'name' => $userFromGoogle->getName(),
                    'email' => $userFromGoogle->getEmail(),
                    'status' => 1,
                    'password' => '$2y$10$6k999SlRLYpCBaMlRxYwjeWX3fB8GsFTZjQ0KEknlka5b99qTA2s6',
                ]);
    
                $newUser->save();
    
                // Login user yang baru dibuat
                Auth::guard('wisatawans')->login($newUser);
                session()->regenerate();
    
                return redirect()->route('wisatawan.home')->with('success_access', 'Selamat datang');
            }
        }
    
        // Jika ada user langsung login saja
        Auth::guard('wisatawans')->login($userFromDatabase);
        session()->regenerate();
    
        return redirect()->route('wisatawan.home')->with('success_access', 'Selamat datang');
    }



}
