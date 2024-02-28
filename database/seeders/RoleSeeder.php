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

        $master = User::create([
            'name' => 'sysad',
            'email' => 'sysad@apollo.api',
            'password' => Hash::make('シープ'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $mayors = User::create([
            'name' => 'mayors',
            'email' => 'mayors@dept.tg',
            'password' => Hash::make('シープ'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $pio = User::create([
            'name' => 'pio',
            'email' => 'pio@dept.tg',
            'password' => Hash::make('シープ'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $admin = User::create([
            'name' => 'admins',
            'email' => 'admins@dept.tg',
            'password' => Hash::make('シープ'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // $adminRole -> givePermissionTo([
        //     'user_access',
        //     'user_create',
        //     'user_update',
        //     'user_delete',
        //     'role_access',
        //     'role_create',
        //     'permission_access',
        //     'permission_create',
        //     'post_access',
        //     'post_create',
        //     'post_update',
        //     'post_delete',                                  
        // ]);

        // $masterRole = Role::create(['name' => 'system']);
        // $adminRole = Role::create(['name' => 'admin']);

        $permissions = Permission::pluck('id', 'id') -> all();

        $masterRole = Role::create(['guard_name' => 'api', 'name' => 'system']);
        $adminRole = Role::create(['guard_name' => 'api', 'name' => 'admin']);

        

        $masterRole -> syncPermissions($permissions);
        $adminRole -> syncPermissions($permissions);

        $master -> assignRole([$masterRole -> id]);
        $mayors -> assignRole([$adminRole -> id]);
        $pio -> assignRole([$adminRole -> id]);
        $admin -> assignRole([$adminRole -> id]);
    }
}
