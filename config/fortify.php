<?php

use App\Providers\RouteServiceProvider;
use Laravel\Fortify\Features;

return [

    'guard' => 'web',

    'passwords' => 'users',

    'username' => 'email', // login default credentials (email/password)

    'email' => 'email', // email verification

    'lowercase_usernames' => true,

    'home' => RouteServiceProvider::HOME,

    'prefix' => 'v1',

    'domain' => null,

    'middleware' => ['web'],

    'limiters' => [
        'login' => 'login',
        'two-factor' => 'two-factor',
    ],

    'views' => true, // default: true || enable GET Method into views e.g view('auth.login')

    'features' => [
        Features::registration(),
        Features::resetPasswords(),
        Features::emailVerification(),
        Features::updateProfileInformation(),
        Features::updatePasswords(),
        // Features::twoFactorAuthentication([
        //     'confirm' => true,
        //     'confirmPassword' => true,
        //     'window' => 0,
        // ]),
    ],

];
