<?php

namespace App\Http\Controllers\Api\DataKunjungan;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Company;
use App\Models\User;
use App\Models\Kuliner;
use App\Models\Wisata;
use App\Models\Akomodasi;
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
    
        // Jika user tidak ditemukan, kirimkan error
        if (!$user) {
            return response()->json(['message' => 'Email tidak terdaftar'], 404);
        }
    
        // Cek apakah password cocok
        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Password tidak benar'], 401);
        }
    
        // Ambil role pertama dari user
        $roleName = $user->roles->first()->name;
    
        // Ambil company_id dari user
        $company = Company::where('user_id', $user->id)->first();
        $company_id = $company ? $company->id : null;
    
        // Ambil data wisata, kuliner, dan akomodasi berdasarkan company_id
        $wisata = Wisata::where('company_id', $company_id)->first();
        $kuliner = Kuliner::where('company_id', $company_id)->first();
        $akomodasi = Akomodasi::where('company_id', $company_id)->first();
    
        // Generate token untuk user
        $token = $user->createToken('AppToken')->accessToken;
    
        // Log untuk debug
        Log::info('Company ID:', ['company_id' => $company_id]);
        Log::info('Wisata Data:', ['wisata' => $wisata]);
        Log::info('Kuliner Data:', ['kuliner' => $kuliner]);
        Log::info('Akomodasi Data:', ['akomodasi' => $akomodasi]);
    
        // Cek role pengguna dan berikan respons sesuai role
        if ($user->hasRole('admin')) {
            return response()->json([
                'status' => 'success',
                'message' => 'Login berhasil',
                'data' => [
                    'role' => $roleName,
                    'token' => $token
                ]
            ], 200);
        } elseif ($user->hasRole('wisata')) {
            // Cek apakah wisata ada dan namawisata tidak null
            if ($wisata && $wisata->namawisata) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Login berhasil',
                    'data' => [
                        'role' => $roleName,
                        'token' => $token,
                        'wisata' => $wisata->namawisata
                    ]
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Wisata profile belum lengkap atau namawisata tidak ditemukan.'
                ], 404);
            }
        } elseif ($user->hasRole('kuliner')) {
            // Cek apakah kuliner ada dan namakuliner tidak null
            if ($kuliner && $kuliner->namakuliner) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Login berhasil',
                    'data' => [
                        'role' => $roleName,
                        'token' => $token,
                        'kuliner' => $kuliner->namakuliner
                    ]
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Kuliner profile belum lengkap atau namakuliner tidak ditemukan.'
                ], 404);
            }
        } elseif ($user->hasRole('akomodasi')) {
            // Cek apakah akomodasi ada dan namaakomodasi tidak null
            if ($akomodasi && $akomodasi->namaakomodasi) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Login berhasil',
                    'data' => [
                        'role' => $roleName,
                        'token' => $token,
                        'akomodasi' => $akomodasi->namaakomodasi
                    ]
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Akomodasi profile belum lengkap atau namaakomodasi tidak ditemukan.'
                ], 404);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Role tidak dikenali.'
            ], 404);
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
