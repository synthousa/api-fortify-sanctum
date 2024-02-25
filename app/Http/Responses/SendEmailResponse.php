<?php

namespace App\Http\Responses;

use Laravel\Fortify\Fortify;
use App\Contracts\Contract;

class SendEmailResponse implements Contract {

    public function toResponse($request) {
        return $request -> wantsJson()
            ? response() -> json(['message' => 'email verification sent'], 200)
            : back()->with('status', Fortify::VERIFICATION_LINK_SENT);
    }
}