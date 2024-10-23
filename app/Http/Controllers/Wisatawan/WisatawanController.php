<?php

namespace App\Http\Controllers\Wisatawan;

use App\Http\Controllers\Controller;
use App\Jobs\Wisatawan\ForgotPassword;
use App\Models\Wisatawan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;


class WisatawanController extends Controller
{
    public function login()
    {
        // dd(Auth::guard('wisatawans')->check());
        if (Auth::guard('wisatawans')->check())  return redirect()->route('wisatawan.home');
        return view('wisatawan.auth.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = Wisatawan::where('email', $request->username)->orWhere('phone', $request->username)->first();
        if (!$user) { // to find user if user not found
            return redirect()->back()->withErrors(['username' => 'Username anda tidak terdaftar'])->withInput();
        }
        if ($user->status != 1) {
            return redirect()->back()->withErrors(['username' => 'User tidak dapat mengakses '])->withInput();
        }

        $credentials = $request->only('username', 'password');

        if (Auth::guard('wisatawans')->attempt(['email' => $credentials['username'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            return redirect()->route('wisatawan.home')->with('success_access', 'Selamat datang');
        }

        // Jika tidak berhasil, coba untuk melakukan login dengan nomor telepon
        if (Auth::guard('wisatawans')->attempt(['phone' => $credentials['username'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            return redirect()->route('wisatawan.home')->with('success_access', 'Selamat datang');
        }

        // Jika tidak berhasil, kembalikan dengan pesan kesalahan
        return redirect()->back()->withErrors(['username' => 'Email atau nomor telepon tidak valid'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::guard('wisatawans')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('wisatawan.login');
    }
    public function registration()
    {
        return view('wisatawan.auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:wisatawan',
            'phone' => 'required|numeric|unique:wisatawan',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            try {
                DB::beginTransaction();
                $wisatawan = Wisatawan::create([
                    'name' => htmlspecialchars($request->name, ENT_QUOTES, 'UTF-8'),
                    'email' => htmlspecialchars($request->email, ENT_QUOTES, 'UTF-8'),
                    'phone' => htmlspecialchars($request->phone, ENT_QUOTES, 'UTF-8'),
                    'password' => Hash::make($request->password),
                    'status' => 1,
                    'created_at' => now(),
                ]);
                if ($wisatawan) {
                    DB::commit();
                    return redirect()->route('wisatawan.login')->with('success_message', 'Akun anda berhasil dibuat, silahkan login');
                } else {
                    return redirect()->route('wisatawan.registration')->with('error_message', 'Akun tidak berhasil dibuat');
                }
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->route('wisatawan.registration')->with('error_message', 'Terjadi kesalahan, silahkan coba lagi');
            }
        }
    }
    public function forgotPassword()
    {
        return view('wisatawan.auth.forgot-password');
    }

    public function resetPassword(Request $request)
    {
        try {
            $wisatawan = Wisatawan::where('email', $request->email)->first();
            if (isset($wisatawan)) {
                $token = Str::random(40); // generate random string
                $wisatawan->update([
                    'password_reset_token' => $token,
                ]);
                $sending_email = ForgotPassword::dispatch($wisatawan);
                return redirect()->route('wisatawan.login')->with('success_message', 'Email berhasil dikirim, silahkan cek email anda');
            } else {
                return redirect()->route('wisatawan.forgot-password')->with('success_message', 'Email tidak ditemukan');
            }
        } catch (Exception $e) {
            return redirect()->route('wisatawan.login')->with('success_message', 'Link tidak Valid, silahkan hubungi admin');
        }
    }

    public function resetPasswordIndex(Request $request)
    {
        try {
            $wisatawan = Wisatawan::where('id', $request->id)->first();
            if (isset($wisatawan)) {
                if ($wisatawan->password_reset_token != $request->token) {
                    return redirect()->route('wisatawan.login')->with('success_message', 'Token tidak sesuai');
                }
                return view('wisatawan.auth.reset-Password', compact('wisatawan'));
            } else {
                return redirect()->route('wisatawan.login')->with('success_message', 'Data tidak ditemukan');
            }
        } catch (Exception $e) {
            return redirect()->route('wisatawan.login')->with('success_message', 'Link Tidak Valid, silahkan hubungi admin');
        }
    }

    public function createResetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed|min:8',
        ], [
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            try {
                $wisatawan = Wisatawan::where('id', $request->id)->first();
                if (isset($wisatawan)) {
                    if ($wisatawan->password_reset_token != $request->token) {
                        return redirect()->route('wisatawan.login')->with('success_message', 'Token tidak sesuai');
                    } else {
                        DB::beginTransaction();
                        $password = Hash::make($request->password);
                        $wisatawan = Wisatawan::lockforUpdate()->update([
                            'password' => $password,
                            'password_reset_token' => null,
                        ]);
                        if (isset($wisatawan)) {
                            DB::commit();
                            return redirect()->route('wisatawan.login')->with('success_message', 'Password berhasil dibuat');
                        } else {
                            return redirect()->route('wisatawan.registration')->with('success_message', 'Akun tidak berhasil dibuat');
                        }
                    }
                } else {
                    return redirect()->route('wisatawan.login')->with('success_message', 'Data tidak ditemukan');
                }
            } catch (Exception $e) {
                return redirect()->route('wisatawan.login')->with('success_message', 'Link tidak Valid, silahkan hubungi admin');
            }
        }
    }

    public function indexChangePassword()
    {
        return view('wisatawan.profil.changePassword');
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed|min:8',
        ], [
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            try {
                $wisatawan = Wisatawan::where('id', auth()->guard('wisatawans')->user()->id)->first();
                if (isset($wisatawan)) {
                    DB::beginTransaction();
                    $password = Hash::make($request->password);
                    $wisatawan = Wisatawan::lockforUpdate()->update([
                        'password' => $password,
                        'password_reset_token' => null,
                    ]);
                    if ($wisatawan) {
                        DB::commit();
                        return redirect()->route('wisatawan.index-change-password')->with('success_message', 'Password berhasil dirubah');
                    } else {
                        return redirect()->route('wisatawan.index-change-password')->with('success_message', 'password tidak berhasil dibuat');
                    }
                } else {
                    return redirect()->route('wisatawan.index-change-password')->with('success_message', 'Link tidak valid, silahkan hubungi admin');
                }
            } catch (Exception $e) {
                return redirect()->route('wisatawan.index-change-password')->with('success_message', 'Link tidak valid, silahkan hubungi admin');
            }
        }
    }

    public function edit()
    {
        $wisatawan = auth()->guard('wisatawans')->user();
        return view('wisatawan.profil.changeProfile', compact('wisatawan'));
    }
    


    public function update(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required',
        'email' => 'required|email',
        'phone' => 'required',
        'password' => 'same:confirm-password',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 400);
    }

    try {
        $user = Auth::guard('wisatawans')->user();

        if (!$user) {
            return redirect()->route('wisatawan.changeprofile')->with('error', 'User tidak ditemukan');

        }

        $input = $request->all();

        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        }

        $user->update([
            'name' => $input['name'],
            'email' => $input['email'],
            'phone' => $input['phone'],
            'password' => $input['password'] ?? $user->password,
            'updated_at' => now(),
        ]);

        return redirect()->route('wisatawan.home')->with('success', 'User updated successfully');
    } catch (\Exception $e) {
        return redirect()->route('wisatawan.changeprofile')->with('error', 'Failed to update user. Please try again.');
    }
}
    

}
