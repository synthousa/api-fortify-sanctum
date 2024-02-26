<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\{ LogoutController };
use Laravel\Fortify\Http\Controllers\{AuthenticatedSessionController, RegisteredUserController, PasswordResetLinkController, ProfileInformationController, PasswordController};

Route::group(['prefix' => 'auth', 'as' => 'auth.', 'middleware' => ['auth:sanctum']], function() {

    Route::withoutMiddleware(['auth:sanctum']) -> group(function () {
        $limit = config('fortify.limiters.login');

        Route::post('login', [AuthenticatedSessionController::class, 'store'])
            -> middleware(array_filter(['guest:'.config('fortify.guard'), $limit ? 'throttle:'.$limit : null]));

        Route::post('register', [RegisteredUserController::class, 'store']) 
            -> middleware('guest:'.config('fortify.guard'));

        Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
            -> middleware('guest:'.config('fortify.guard'))
            -> name('password.email');
    });

    $verificationLimiter = config('fortify.limiters.verification', '6,1');

    // Route::post('email/verification-notification', [EmailVerificationController::class, 'store']) -> middleware(['throttle:'.$verificationLimiter]);
    Route::post('logout', [LogoutController::class, 'destroy']);

    Route::prefix('user') -> middleware('verified') -> group(function () {

        Route::get('/', fn (Request $request) => $request -> user()) -> name('user');

        Route::put('profile', [ProfileInformationController::class, 'update']);

        Route::put('password', [PasswordController::class, 'update']);
    });
});


