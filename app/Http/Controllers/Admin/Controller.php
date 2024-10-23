<?php

namespace App\Http\Controllers;

use App\Helpers\Cryptography;
use App\Models\ListOfValue;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class Controller extends BaseController
{
    public function __construct()
    {
        // Atur bahasa sesuai preferensi pengguna yang disimpan dalam sesi atau cookie
        $locale = session()->get('locale', config('app.kernel'));
        app()->setLocale($locale);
    }
}
