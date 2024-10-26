<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;


class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        //
    }
    public function render($request, Throwable $exception)
    {
        // Menangani akses dengan parameter XDEBUG_SESSION_START
    //     if ($request->has('XDEBUG_SESSION_START')) {
    //         return response('Access Denied.', 403);
    //     }
    //     if ($exception instanceof \Spatie\Permission\Exceptions\UnauthorizedException) {
    //         return response()->json(['message' => 'Anda tidak memiliki izin untuk mengakses halaman ini.'], 403);
    //     }
    
    //     // Menangani pengecualian terkait database
    //     if ($exception instanceof \Illuminate\Database\QueryException) {
    //         // Memeriksa apakah pengecualian adalah masalah panjang data
    //         if ($exception->getCode() === '22001') {
    //             return response()->view('errors.506', [], 506);
    //         }
    //     }
    
    //     // Menangani pengecualian kesalahan umum
    //     if ($exception instanceof \ErrorException) {
    //         return response()->view('errors.504', [], 504);
    //     }
    //    //tandai jika bypas Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException
    
    //     // Menangani pengecualian terkait file
    //     if ($exception instanceof \Symfony\Component\HttpFoundation\File\Exception\FileException) {
    //         return response()->view('errors.504', [], 504);
    //     }
    
    //     // Menangani pengecualian token tidak sesuai
    //     if ($exception instanceof \Illuminate\Session\TokenMismatchException) {
    //         return response()->view('errors.504', [], 504);
    //     }
    
    //     // Menangani pengecualian halaman tidak ditemukan
    //     if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
    //         return response()->view('errors.404', [], 404);
    //     }
    
    //     // // Menangani pengecualian lainnya secara default
    //     // return response()->view('errors.404', [], 404);
    
    //     // Menangani pengecualian metode tidak diizinkan
    //     if ($exception instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException) {
    //         return response()->view('errors.504', [], 504);
    //     }

        // Mengembalikan perilaku default untuk semua pengecualian lainnya
        return parent::render($request, $exception);
    }
    
    
}

