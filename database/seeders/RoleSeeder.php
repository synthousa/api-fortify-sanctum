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
            'password' => Hash::make('taguiggov'),
            'employee_id' => '00000',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $mayors = User::create([
            'name' => 'mayors',
            'email' => 'mayors@dept.tg',
            'password' => Hash::make('taguiggov'),
            'employee_id' => '00001',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $pio = User::create([
            'name' => 'pio',
            'email' => 'pio@dept.tg',
            'password' => Hash::make('taguiggov'),
            'employee_id' => '00002',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $admin = User::create([
            'name' => 'admins',
            'email' => 'admins@dept.tg',
            'password' => Hash::make('taguiggov'),
            'employee_id' => '00003',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $permissions = Permission::pluck('id', 'id') -> all();

        $masterRole = Role::create(['guard_name' => 'api', 'name' => 'system']);
        $adminRole = Role::create(['guard_name' => 'api', 'name' => 'admin']);
        $modRole = Role::create(['guard_name' => 'api', 'name' => 'moderator']);

        $masterRole -> syncPermissions($permissions);
        $adminRole -> syncPermissions($permissions);
        $modRole -> syncPermissions([
            'post_access',
            'post_item',
            'post_create',
            'post_update',
        ]);

        $master -> assignRole([$masterRole -> id]);
        $mayors -> assignRole([$adminRole -> id]);
        $pio -> assignRole([$adminRole -> id]);
        $admin -> assignRole([$adminRole -> id]);
    }
}
