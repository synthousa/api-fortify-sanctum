<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Account\{UserController, RoleController, PostController };
use Laravel\Fortify\Http\Controllers\{AuthenticatedSessionController, RegisteredUserController, PasswordResetLinkController, ProfileInformationController, PasswordController};

Route::group(['middleware' => ['auth:api']], function() {

    Route::prefix('auth')->group(function () {

        Route::withoutMiddleware(['auth:api'])->group(function () {
            $limit = config('fortify.limiters.login');

            Route::post('login', [AuthenticatedSessionController::class, 'store'])
                -> middleware(array_filter(['guest:'.config('fortify.guard'), $limit ? 'throttle:'.$limit : null]));

            Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                -> middleware('guest:'.config('fortify.guard'))
                -> name('password.email');
        });

        Route::middleware('verified')->group(function () {

            Route::get('profile', fn (Request $request) => $request -> user()) -> name('user');
            Route::put('profile', [ProfileInformationController::class, 'update']);
            Route::put('change-password', [PasswordController::class, 'update']);
        });

        Route::post('logout', [LogoutController::class, 'destroy']);
    });

    Route::prefix('account')->group(function () {
        
        Route::resources([
            'users' => UserController::class,
            'posts' => PostController::class
        ]);
    });
});