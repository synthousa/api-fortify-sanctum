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
            'email' => 'sysad@tg.gov',
            'password' => Hash::make('シープ'),
            'employee_id' => '40000',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $permissions = Permission::pluck('id', 'id') -> all();

        $masterRole -> syncPermissions($permissions);
        $master -> assignRole([$masterRole -> id]);
        
        $mayors = User::create([
            'name' => 'Francine Vamplers',
            'email' => 'fvamplersk@weibo.com',
            'password' => Hash::make('シープ'),
            'employee_id' => '37401',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $pio = User::create([
            'name' => 'Jillie Lowey',
            'email' => 'jloweyf@google.pl',
            'password' => Hash::make('シープ'),
            'employee_id' => '30703',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $admin = User::create([
            'name' => 'Broddie Coope',
            'email' => 'bcoope1l@sakura.ne.jp',
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
