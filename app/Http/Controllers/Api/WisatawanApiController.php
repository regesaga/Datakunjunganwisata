<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Jobs\Wisatawan\ForgotPassword;
use App\Models\Wisatawan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\JsonResponse;
use Kreait\Firebase\Auth as FirebaseAuth;
use Laravel\Socialite\Contracts\User as SocialiteUser;
class WisatawanApiController extends Controller
{




public function authenticate(Request $request)
{
    $request->validate([
        'username' => 'required',
        'password' => 'required',
    ]);

    $user = Wisatawan::where('email', $request->username)->orWhere('phone', $request->username)->first();
    if (!$user) {
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
        $token = $user->createToken('Token Name')->accessToken;
        $response = [
            'message' => 'success',
            'token' => $token,
            'token_type' => 'Bearer',
            'ok' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'phone' => $user->phone,
                'email' => $user->email
            ]
        ];
    
        return response()->json($response, 200);
    }

    // Jika tidak berhasil, coba untuk melakukan login dengan nomor telepon
    if (Auth::guard('wisatawans')->attempt(['phone' => $credentials['username'], 'password' => $credentials['password']])) {
        $token = $user->createToken('Token Name')->accessToken;
        $response = [
            'message' => 'success',
            'token' => $token,
            'token_type' => 'Bearer',
            'ok' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'phone' => $user->phone,
                'email' => $user->email
            ]
        ];
    
        return response()->json($response, 200);
    }

    // Jika tidak berhasil, kembalikan dengan pesan kesalahan
    return response([
        'success'   => false,
        'message' => ['Email atau nomor telepon tidak valid']
    ], 404);
}

    
    public function redirectToAuth(): JsonResponse
    {
        return response()->json([
            'url' => Socialite::driver('google')
                         ->stateless()
                         ->redirect()
                         ->getTargetUrl(),
        ]);
    }

    protected $firebaseAuth;

    public function __construct(FirebaseAuth $firebaseAuth)
    {
        $this->firebaseAuth = $firebaseAuth;
    }

    public function googleLogin(Request $request)
{
    $idTokenString = $request->input('token');

    try {
        $verifiedIdToken = $this->firebaseAuth->verifyIdToken($idTokenString);
        $google_id = $verifiedIdToken->claims()->get('sub');
        $name = $verifiedIdToken->claims()->get('name');
        $email = $verifiedIdToken->claims()->get('email');

        // Cari pengguna di database berdasarkan google_id
        $user = Wisatawan::where('google_id', $google_id)->first();
        if ($user) {
            // Update google_id if it has changed
            if ($user->google_id !== $google_id) {
                $user->update(['google_id' => $google_id]);
            }
            // Log in the user
            Auth::login($user);

            $token = $user->createToken('AppName')->accessToken;

            $response = [
                'message' => 'success',
                'token' => $token,
                'token_type' => 'Bearer',
                'ok' => true,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'phone' => $user->phone,
                    'email' => $user->email
                ]
            ];

            return response()->json($response, 200);
        } else {
            // Cek apakah email sudah terdaftar
            $existingUser = Wisatawan::where('email', $email)->first();
            if ($existingUser) {
                // Email sudah terdaftar, langsung login
                Auth::login($existingUser);

                $token = $existingUser->createToken('AppName')->accessToken;

                $response = [
                    'message' => 'success',
                    'token' => $token,
                    'token_type' => 'Bearer',
                    'ok' => true,
                    'user' => [
                        'id' => $existingUser->id,
                        'name' => $existingUser->name,
                        'phone' => $existingUser->phone,
                        'email' => $existingUser->email
                    ]
                ];

                return response()->json($response, 200);
            } else {
                // Jika pengguna tidak ditemukan dan email belum terdaftar, buat pengguna baru
                $user = new Wisatawan([
                    'google_id' => $google_id,
                    'name' => $name,
                    'email' => $email,
                    'status' => 1,
                    'password' => bcrypt(Str::random(16)), // atau gunakan password default yang dienkripsi
                ]);
                $user->save();

                Auth::login($user);

                $token = $user->createToken('AppName')->accessToken;

                $response = [
                    'message' => 'success',
                    'token' => $token,
                    'token_type' => 'Bearer',
                    'ok' => true,
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'phone' => $user->phone,
                        'email' => $user->email
                    ]
                ];

                return response()->json($response, 200);
            }
        }
    } catch (\InvalidArgumentException $e) {
        return response()->json(['message' => 'Invalid token'], 400);
    } catch (InvalidToken $e) {
        return response()->json(['message' => 'Invalid token'], 400);
    }
}




    public function logout(Request $request)
    {
        Auth::guard('wisatawans')->logout(); // Logout the user authenticated via the 'wisatawans' guard
        $request->session()->invalidate(); // Invalidate the user's session
        $request->session()->regenerateToken(); // Regenerate the CSRF token for security purposes
        
        return response()->json(['status' => 'success', 'message' => 'Berhasil logout', 'ok' => true], 200); // Return a JSON response indicating success
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

 

    // Check if email or phone already exists
    $existingUser = Wisatawan::where('email', $request->email)->orWhere('phone', $request->phone)->first();
    if ($existingUser) {
        $message = [];
        if ($existingUser->email === $request->email) {
            $message['email'] = 'Email sudah digunakan. Gunakan email lain.';
        }
        if ($existingUser->phone === $request->phone) {
            $message['phone'] = 'Nomor telepon sudah digunakan. Gunakan nomor telepon lain.';
        }
        return response()->json(['status' => 'Oops', 'message' => $message], 422);
    }

    try {
        DB::beginTransaction();
        $password = Hash::make($request->password);
        $wisatawan = Wisatawan::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $password,
            'status' => 1,
            'created_at' => now(),
        ]);
        DB::commit();

        return response()->json(['status' => 'success', 'message' => 'success'], 200);
    } catch (Exception $e) {
        return response()->json(['status' => 'Oops', 'message' => 'Akun tidak berhasil dibuat'], 500);
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
            return redirect()->route('wisatawan.login')->with('success_message', 'Error, silahkan hubungi admin');
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
            return redirect()->route('wisatawan.login')->with('success_message', 'Error, silahkan hubungi admin');
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
                return redirect()->route('wisatawan.login')->with('success_message', 'Error, silahkan hubungi admin');
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
                    return redirect()->route('wisatawan.index-change-password')->with('success_message', 'Error, silahkan hubungi admin');
                }
            } catch (Exception $e) {
                return redirect()->route('wisatawan.index-change-password')->with('success_message', 'Error, silahkan hubungi admin');
            }
        }
    }






    public function profile()
{
    $wisatawan = auth()->guard('wisatawans')->user();
    return response()->json(['wisatawan' => $wisatawan]);
}

public function update(Request $request, $id)
{
    $wisatawan = Wisatawan::find($id);

    if (!$wisatawan) {
        return response()->json(['Oops' => 'User tidak ada found'], 404);
    }

    $validator = Validator::make($request->all(), [
        'name' => 'required',
        'email' => 'required|email',
        'phone' => 'required',
        'password' => 'nullable|confirmed',
    ]);

    if ($validator->fails()) {
        return response()->json(['Oops' => $validator->errors()->all()], 400);
    }

    $input = $request->only(['name', 'email', 'phone']);
    if ($request->has('password')) {
        $input['password'] = Hash::make($request->input('password'));
    }

    $wisatawan->update($input);

    return response()->json(['message' => 'User updated successfully'], 200);
}
}
