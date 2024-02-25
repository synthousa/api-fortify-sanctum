<?php

namespace App\Http\Responses;

use Laravel\Fortify\Fortify;
use App\Contracts\Contract;

class HasEmailResponse implements Contract {

    public function toResponse($request) {
        return $request -> wantsJson()
            ? response() -> json(['message' => 'your email is already verified'], 200)
            : redirect()->intended(Fortify::redirects('email-verification'));
    }
}