<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Article;
use App\Policies\PostPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider {

    protected $policies = [

        Article::class => PostPolicy::class
    ];

    public function boot(): void {

        Gate::before(function (User $user, $ability) {
            return $user -> hasRole('system') ? true : null;
        });
    }
}
