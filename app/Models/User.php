<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable {
    
    use HasApiTokens, HasRoles, HasFactory, Notifiable;

    protected $guard_name = 'api';

    protected $fillable = [
        'name',
        'email',
        'password',
        // 'employee_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // public function roles() {
    //     return $this->belongsToMany(Role::class);
    // }

    // public function permissions() {
    //     return $this->belongsToMany(Permission::class);
    // }

    public function articles() {
        return $this -> hasMany(Comment::class);
    }
}
