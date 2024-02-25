<?php

namespace App\Exceptions;

use Exception;

class TokenMismatchException extends Exception {

    public function render($request) {

        if ($request -> wantsJson()) {
            return response() -> json(['message' => 'access denied'], 401);
        }

        return abort(403);
    }
}
