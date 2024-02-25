<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;

// use Illuminate\Support\Facades\DB;
use App\Exceptions\TokenMismatchException;

class EnsureTokenIsValid {

    public function handle(Request $request, Closure $next) {

        if ($request -> bearerToken()) {
            // return response() -> json(['message' => 'some stuff'], 200);
            return $next($request);

        }

        throw new TokenMismatchException;


        // return $next($request);

        // try {



        // } catch (Throwable $e) {

        //     return response() -> json(['token_expired'], 401);
        // }

        // if ($request -> wantsJson()) {

        // }



        // [$id, $token] = explode('|', $request -> bearerToken(), 2);

        // $instance = DB::table('personal_access_tokens') -> find($id);

        // if (hash('sha256', $token) === $instance -> token) {

        //     if ($user = \App\Models\User::find($instance -> tokenable_id)) {
                
        //         Auth::login($user);

        //         $request -> headers -> set('Accept', 'application/json');
        //         
        //     }
        // }
        // abort(403);
    }
}
