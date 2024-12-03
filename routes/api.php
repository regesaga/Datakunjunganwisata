<?php

use App\Http\Controllers\EmailVerificationNotificationController;
use App\Http\Controllers\Api\PaketWisataApiController;
use App\Http\Controllers\Api\WisatawanApiController;
use App\Http\Controllers\Api\WisataApiController;
use App\Http\Controllers\Api\KulinerApiController;
use App\Http\Controllers\Api\PesanTiketApiController;
use App\Http\Controllers\Api\PesanAkomodasiApiController;
use App\Http\Controllers\Api\PesanKulinerApiController;
use App\Http\Controllers\Api\AkomodasiApiController;
use App\Http\Controllers\Api\EvencalenderApiController;
use App\Http\Controllers\Api\BanerApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Api\WisatawanAuthApiController;
use App\Http\Controllers\Api\DataKunjungan\AuthApiController;

/**
 * Wisawatan Section
 */




$verificationLimiter = config('fortify.limiters.verification', '6.1');

Route::group(['middleware' => 'auth:sanctum'], function () {

    //Authentication routes 
    Route::prefix('auth')->withoutMiddleware('auth:sanctum')->group(function () {
        //Retrive the limiter configuration for login attempts
        $limiter = config('fortify.limiters.login');

        //Route for user login
        Route::post('/login', [AuthenticatedSessionController::class, 'store'])
            ->middleware(array_filter([
                'guest:' . config('fortify.guard'),
                $limiter ? 'throttle:' . $limiter : null,
            ]));

        //Route for User registration 
        Route::post('/register', [RegisteredUserController::class, 'store'])
            ->middleware('guest:' . config('fortify.guard'));

        //Route for initiating password reset
        Route::get('/v1/forgot-password', [PasswordResetLinkController::class, 'store'])
            ->middleware('guest:' . config('fortify.guard'))->name('password.request');
    });
});


Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware([
        'auth:sanctum',
        'throttle:' . $verificationLimiter
    ]);






//Route::post('wisata/media', [\App\Http\Controllers\Api\WisataApiController::class, 'storeMedia'])->name('wisata.storeMedia');
Route::apiResource('paketwisata', PaketWisataApiController::class);
Route::apiResource('banner', BanerApiController::class);
Route::apiResource('wisata', WisataApiController::class);
Route::apiResource('kuliner', KulinerApiController::class);
Route::apiResource('akomodasi', AkomodasiApiController::class);
Route::apiResource('evencalender', EvencalenderApiController::class);


// Route::get('wisata', [WisataApiController::class, 'get']);
Route::get('/paketwisata/{id}', [PaketWisataApiController::class, 'lihat']);
Route::get('/evencalender/{id}', [EvencalenderApiController::class, 'lihat']);
Route::get('/wisata/{id}', [WisataApiController::class, 'lihat']);
Route::get('/akomodasi/{id}', [AkomodasiApiController::class, 'lihat']);
// routes/api.php atau routes/web.php (sesuaikan dengan kebutuhan)
Route::post('akomodasi/{id}/review', [AkomodasiApiController::class, 'storeReview']);
Route::put('akomodasi/{id}/review/{reviewId}', [AkomodasiApiController::class, 'updateReview']);

Route::post('kuliner/{id}/review', [KulinerApiController::class, 'storeReview']);
Route::put('kuliner/{id}/review/{reviewId}', [KulinerApiController::class, 'updateReview']);


Route::post('paketwisata/{id}/review', [PaketWisataApiController::class, 'storeReview']);
Route::put('paketwisata/{id}/review/{reviewId}', [PaketWisataApiController::class, 'updateReview']);

Route::post('wisata/{id}/review', [WisataApiController::class, 'storeReview']);
Route::put('wisata/{id}/review/{reviewId}', [WisataApiController::class, 'updateReview']);




Route::get('/kuliner/{id}', [KulinerApiController::class, 'lihat']);

Route::get('/reserv/{akomodasi_id}', [PesanAkomodasiApiController::class, 'reserv']);
Route::post('/reservations', [PesanAkomodasiApiController::class, 'store']);



Route::post('/checkoutReservFinishApi', [PesanAkomodasiApiController::class, 'checkoutReservFinishApi']);
Route::get('cetakreserv/{kodeboking}', [PesanAkomodasiApiController::class, 'cetakreserv']);
Route::get('historireserv/{id}', [PesanAkomodasiApiController::class, 'riwayatreserv']);



Route::get('/pesantiket/{wisata_id}', [PesanTiketApiController::class, 'pesantiket']);
Route::post('/tickets', [PesanTiketApiController::class, 'store']);



Route::post('/checkoutFinishApi', [PesanTiketApiController::class, 'checkoutFinishApi']);
Route::get('cetaktiket/{kodetiket}', [PesanTiketApiController::class, 'cetaktiket']);
Route::get('histori/{id}', [PesanTiketApiController::class, 'pesanantiketwisatawan']);



Route::get('/pesankuliner/{kuliner_id}', [PesanKulinerApiController::class, 'pesankuliner']);
Route::post('/pesanan', [PesanKulinerApiController::class, 'store']);



Route::post('/checkoutkulinerFinishApi', [PesanKulinerApiController::class, 'checkoutkulinerFinishApi']);
Route::get('cetakpesanan/{kodepesanan}', [PesanKulinerApiController::class, 'cetakpesanan']);
Route::get('historipesanan/{id}', [PesanKulinerApiController::class, 'pesanankulinerwisatawan']);



Route::group(['prefix' => 'wisatawan'], function () {
    Route::post('/login', [WisatawanApiController::class, 'authenticate']);
    Route::post('/logout', [WisatawanApiController::class, 'logout']);
    Route::post('/register', [WisatawanApiController::class, 'register']);
    Route::post('/forgot-password', [WisatawanApiController::class, 'forgotPassword']);
    Route::post('/reset-password/{email}', [WisatawanApiController::class, 'resetPassword']);
    Route::post('/change-password', [WisatawanApiController::class, 'changePassword']);
    Route::put('wisatawans/{id}', [WisatawanApiController::class, 'update']);
    

});

Route::post('/login/google', [WisatawanApiController::class, 'googleLogin']);

// routes/api.php
Route::post('/datakunjungan/login', [AuthApiController::class, 'login']);


Route::middleware(['auth:sanctum', 'role:admin'])->get('/admin-dashboard', function () {
    return response()->json(['message' => 'Welcome Admin to the Dashboard']);
});

Route::middleware(['auth:sanctum', 'role:wisata'])->get('/wisata-dashboard', function () {
    return response()->json(['message' => 'Welcome Wisata to the Dashboard']);
});

Route::middleware(['auth:sanctum', 'role:kuliner'])->get('/kuliner-dashboard', function () {
    return response()->json(['message' => 'Welcome Kuliner to the Dashboard']);
});

Route::middleware(['auth:sanctum', 'role:akomodasi'])->get('/akomodasi-dashboard', function () {
    return response()->json(['message' => 'Welcome Akomodasi to the Dashboard']);
});
