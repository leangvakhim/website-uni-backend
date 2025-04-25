<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {

        $permissions = [
            'view dashboard',
            'edit content',
            'delete content',
            'manage users',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'api',
            ]);
        }

      
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'api']);
        $editor = Role::firstOrCreate(['name' => 'editor', 'guard_name' => 'api']);
        $viewer = Role::firstOrCreate(['name' => 'viewer', 'guard_name' => 'api']);

        // 1. Assign permissions to roles
        $admin->givePermissionTo(Permission::all());

        $editor->givePermissionTo([
            'view dashboard',
            'edit content',
        ]);

        $viewer->givePermissionTo([
            'view dashboard',
        ]);

        // 2. Create admin user
        $adminUser = User::firstOrCreate([
            'username' => 'adminuser'
        ], [
            'password' => Hash::make('admin123'),
        ]);

        // 3. Assign role
        $adminUser->assignRole('admin');
    }
}
