<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LogoutController;
use Laravel\Fortify\Http\Controllers\{
    AuthenticatedSessionController, 
    RegisteredUserController, 
    PasswordResetLinkController, 
    ProfileInformationController, 
    PasswordController
};

Route::group(['prefix' => 'auth', 'as' => 'auth.', 'middleware' => ['auth:api']], function() {

    Route::withoutMiddleware(['auth:api']) -> group(function () {
        $limit = config('fortify.limiters.login');

        Route::post('login', [AuthenticatedSessionController::class, 'store'])
            -> middleware(array_filter(['guest:'.config('fortify.guard'), $limit ? 'throttle:'.$limit : null]));

        Route::post('register', [RegisteredUserController::class, 'store']) 
            -> middleware('guest:'.config('fortify.guard'));

        Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
            -> middleware('guest:'.config('fortify.guard'))
            -> name('password.email');
    });

    Route::post('logout', [LogoutController::class, 'destroy']);

    Route::prefix('user') -> middleware('verified') -> group(function () {

        Route::get('profile', fn (Request $request) => $request -> user()) -> name('user');

        Route::put('profile', [ProfileInformationController::class, 'update']);

        Route::put('password', [PasswordController::class, 'update']);
    });

    
});


// Route::middleware(['auth:api', 'role:system']) -> group(function () {
    
//     Route::get('/admin', function () {
//         return response() -> json(['message' => 'hi Admin']);
//     });
// });


