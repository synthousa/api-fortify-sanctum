<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder {

    public function run(): void {

        $permissions = [
            'user_access',
            'user_profile',
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
            'post_item',
            'post_create',
            'post_update',
            'post_delete',
        ];        

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
