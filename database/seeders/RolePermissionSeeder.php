<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {

        // 1. Create permissions


        $permissions = [
            'view dashboard',
            'view website',
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


        // 2. Create roles
        $admin  = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'api']);
        $editor = Role::firstOrCreate(['name' => 'editor', 'guard_name' => 'api']);
        $viewer = Role::firstOrCreate(['name' => 'viewer', 'guard_name' => 'api']);
        $guest = Role::firstOrCreate(['name' => 'guest', 'guard_name' => 'api']);

        // 3. Assign permissions to roles

        $admin->givePermissionTo(Permission::all());

        $editor->givePermissionTo([
            'view dashboard',
            'edit content',
        ]);

        $viewer->givePermissionTo([
            'view dashboard',
        ]);


        $guest->givePermissionTo([
            'view website',
        ]);

        $guestUser = User::firstOrCreate(
            ['username' => 'csd-guest-user'],
            [
                'password'   => Hash::make('guestpassword'),
                'role'       => 'guest',
                'permission' => 'read-only',
            ]
        );

        // 4. Create admin user WITH role and permission fields
        $adminUser = User::firstOrCreate(
            ['username' => 'csd-admin-user'],
            [
                'password'   => Hash::make('QAZqazWSXwsx12()'),
                'role'       => 'admin',
                'permission' => 'full access',
            ]
        );

        // 5. Assign actual permissioned role

        $adminUser->assignRole('admin');
        $guestUser->assignRole('guest');

        // Optionally generate and log JWT token for admin user
        $token = JWTAuth::fromUser($adminUser);
        // info('Generated JWT Token for admin user: ' . $token);

        $guestToken = JWTAuth::fromUser($guestUser);
        // info('Generated JWT Token for guest user: ' . $guestToken);
    }
}
