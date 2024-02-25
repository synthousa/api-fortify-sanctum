<?php

namespace App\Providers;

use App\Models\User;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;

// use Illuminate\Auth\Events\Registered;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\{LoginResponse, RegisterResponse, 
    ProfileInformationUpdatedResponse, PasswordUpdateResponse, 
    LogoutResponse};

class FortifyServiceProvider extends ServiceProvider {

    public function register(): void {

        $this -> app -> instance(LoginResponse::class, new class implements LoginResponse {
            public function toResponse($request) {
                if ($request -> wantsJson()) {
                    $user = User::where('email', $request -> email) -> first();

                    return response () -> json(['token' => $user -> createToken($user -> email) -> plainTextToken], 200);
                }
                return redirect() -> intended(Fortify::redirects('login'));
            }
        });

        $this -> app -> instance(RegisterResponse::class, new class implements RegisterResponse {
            public function toResponse($request) {
                $user = User::where('email', $request -> email) -> first();

                return $request -> wantsJson()
                    ? response() -> json(['token' => $user -> createToken($user -> email) -> plainTextToken], 201)
                    : redirect() -> intended(Fortify::redirects('register'));
            }
        });

        $this -> app -> instance(LogoutResponse::class, new class implements LogoutResponse {
            public function toResponse($request) {
                return $request -> wantsJson()
                    ? response() -> json(['message' => 'user logged out'], 200)
                    : redirect(Fortify::redirects('logout', '/'));
            }
        });

        $this -> app -> instance(ProfileInformationUpdatedResponse::class, new class implements ProfileInformationUpdatedResponse {
            public function toResponse($request) {
                return $request->wantsJson()
                    ? response() -> json(['message' => 'user profile updated'], 200)
                    : back() -> with('status', Fortify::PROFILE_INFORMATION_UPDATED);
            }
        });

        $this -> app -> instance(PasswordUpdateResponse::class, new class implements PasswordUpdateResponse {
            public function toResponse($request) {
                return $request -> wantsJson()
                    ? response() -> json(['message' => 'password updated'], 200)
                    : back() -> with('status', Fortify::PASSWORD_UPDATED);
            }
        });

        Fortify::ignoreRoutes();
    }

    public function boot(): void {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request -> input(Fortify::username())).'|'.$request -> ip());

            return Limit::perMinute(5) -> by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5) -> by($request -> session() -> get('login.id'));
        });
    }
}
