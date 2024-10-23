<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Responses\HasEmailResponse;
use App\Http\Responses\SendEmailResponse;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;


class EmailVerificationNotificationController extends Controller
{
    public function store(Request $request) : SendEmailResponse
    { 
        if ($request->user()->hasVerifiedEmail()){
            return app(HasEmailResponse::class);
        }

        $request->user()->sendEmailVerificationNotification();

        return app(SendEmailResponse::class);
    }
}
