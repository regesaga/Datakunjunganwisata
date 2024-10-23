<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LanguageController extends Controller
{
    public function switch(Request $request)
    {
        // dd(session()->all());
        $locale = $request->input('locale');
        if (in_array($locale, ['en', 'id'])) {
            App::setLocale($locale);
            session()->put('locale', $locale);
        }else{
            return 'error';
        }

        return back();
    }
}
