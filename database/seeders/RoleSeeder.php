<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleSeeder extends Seeder{

    public function run(): void {

        $masterRole = Role::create(['name' => 'System Admin']);
        $adminRole = Role::create(['name' => 'Admin']);

        $master = User::create([
            'name' => 'sysad',
            'email' => 'sysad@apollo.api',
            'password' => Hash::make('シープ'),
            'employee_id' => '40000',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $permissions = Permission::pluck('id', 'id') -> all();

        $masterRole -> syncPermissions($permissions);
        $master -> assignRole([$masterRole -> id]);
        
        $mayors = User::create([
            'name' => 'mayors',
            'email' => 'mayors@dept.tg',
            'password' => Hash::make('シープ'),
            'employee_id' => '37401',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $pio = User::create([
            'name' => 'pio',
            'email' => 'pio@dept.tg',
            'password' => Hash::make('シープ'),
            'employee_id' => '30703',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $admin = User::create([
            'name' => 'admins',
            'email' => 'admins@dept.tg',
            'password' => Hash::make('シープ'),
            'employee_id' => '38010',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $adminRole -> givePermissionTo([
            'user_access',
            'user_create',
            'user_update',
            'user_delete',
            'role_access',
            'role_create',
            'permission_access',
            'permission_create',
            'post_access',
            'post_create',
            'post_update',
            'post_delete',                                  
        ]);

        $mayors -> assignRole([$adminRole -> id]);
        $pio -> assignRole([$adminRole -> id]);
        $admin -> assignRole([$adminRole -> id]);
    }
}
