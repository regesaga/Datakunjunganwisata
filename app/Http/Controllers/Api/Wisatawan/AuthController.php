<?php

namespace App\Http\Controllers\Api\Wisatawan;

use App\Http\Controllers\Controller;
use App\Models\Wisatawan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = Wisatawan::where('email', $request->username)->orWhere('phone', $request->username)->first();
        if (!$user) { // to find user if user not found
            return response([
                'success'   => false,
                'message' => ['Username anda tidak terdaftar']
            ], 404);
        }
        if ($user->status != 1) {
            return response([
                'success'   => false,
                'message' => ['User telah dinonaktifkan']
            ], 404);
        }

        $credentials = $request->only('username', 'password');

        if (Auth::guard('wisatawans')->attempt(['email' => $credentials['username'], 'password' => $credentials['password']])) {
            $token = Str::random(40);
            $user->update(['verification_token' => $token]);
            $response = [

                'message'   => 'Berhasil Login'
            ];

            return response($response, 200);
        }

        // Jika tidak berhasil, coba untuk melakukan login dengan nomor telepon
        if (Auth::guard('wisatawans')->attempt(['phone' => $credentials['username'], 'password' => $credentials['password']])) {
            $token = Str::random(40);
            $user->update(['verification_token' => $token]);
            $response = [

                'message'   => 'Berhasil Login'
            ];

            return response($response, 200);
        }

        // Jika tidak berhasil, kembalikan dengan pesan kesalahan
        return response([
            'success'   => false,
            'message' => ['Email atau nomor telepon tidak valid']
        ], 404);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed|min:8',
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:wisatawan',
            'phone' => 'required|numeric|unique:wisatawan',
        ], [
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        } else {
            $token = Str::random(40);
            try {
                DB::beginTransaction();
                $password = Hash::make($request->password);
                $wisatawan = Wisatawan::lockforUpdate()->create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'password' => $password,
                    'verification_token' => $token,
                    'status' => 1,
                    'created_at' => now(),
                ]);
                if (isset($wisatawan)) {
                    DB::commit();
                    $response = [
                        'success'   => true,
                        'user'      => $wisatawan,
                        'token'     => $token,
                        'message'   => 'Berhasil Login'
                    ];

                    return response($response, 200);
                } else {
                    return response([
                        'success'   => false,
                        'message' => ['akun tidak berhasil dibuat']
                    ], 404);
                }
            } catch (Exception $e) {
                return response([
                    'success'   => false,
                    'message' => ['akun tidak berhasil dibuat']
                ], 404);
            }
        }
    }

    public function logout(Request $request)
    {
        $wisatawan = Auth::guard('wisatawans');
        return response()->json([
            'message' => 'logout success'
        ]);

    }

}
