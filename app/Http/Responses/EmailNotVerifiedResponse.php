<?php

namespace App\Http\Responses;

use App\Contracts\Contract;

class EmailNotVerifiedResponse implements Contract {

    public function toResponse($request) {
        return $request -> wantsJson()
            ? response() -> json(['message' => 'email is not verified'], 400)
            : '';
    }
}