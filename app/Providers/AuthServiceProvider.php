<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider {

    protected $policies = [
        //
    ];

    public function boot(): void {

        Gate::before(function (User $user, $ability) {
            return $user -> hasRole('System Admin') ? true : null;
        });
    }
}
