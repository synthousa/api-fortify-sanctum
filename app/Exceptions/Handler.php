<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler {

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void {

        // $this -> renderable(function (Throwable $e, $request) {
        //     if ($request -> is('api/*') || $request -> wantsJson()) {

        //         $request -> headers -> set('Accept', 'application/json');
        //     }

        //     return redirect() -> guest('login');
        // });
    }
}
