<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder {

    public function run(): void {

        $permissions = [
            'user_access',
            'user_create',
            'user_update',
            'user_delete',
            'role_access',
            'role_create',
            'role_update',
            'role_delete',
            'permission_access',
            'permission_create',
            'permission_update',
            'permission_delete',
            'post_access',
            'post_create',
            'post_update',
            'post_delete',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        
        // creating a role
        $masterRole = Role::create(['name' => 'System Admin']);
        $adminRole = Role::create(['name' => 'Admin']);

        // permission each role
        $masterRole -> givePermissionTo($permissions);

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

        // premade account
        $master = User::create([
            'name' => 'sysad',
            'email' => 'sysad@tg.gov',
            'password' => Hash::make('シープ'),
            'employee_id' => '40000',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

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

        // assigning the role
        $master -> assignRole($masterRole);
        $mayors -> assignRole($adminRole);
        $pio -> assignRole($adminRole);
        $admin -> assignRole($adminRole);
    }
}
