<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Responses\HasEmailResponse;
use App\Http\Responses\SendEmailResponse;
use Laravel\Fortify\Http\Controllers\EmailVerificationNotificationController as BaseController;

class EmailVerificationController extends BaseController {

    public function store(Request $request) {
        
        if ($request -> user() -> hasVerifiedEmail()) {
            return app(HasEmailResponse::class);
        }

        $request -> user() -> sendEmailVerificationNotification(); 

        return app(SendEmailResponse::class);
    }

}