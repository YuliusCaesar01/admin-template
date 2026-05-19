<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ===== PERMISSIONS =====
        $permissions = [
            'dashboard.view',
            'users.view', 'users.show', 'users.create', 'users.edit', 'users.delete',
            'roles.view', 'roles.create', 'roles.edit', 'roles.delete',
            'permissions.view', 'permissions.create', 'permissions.edit', 'permissions.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name'       => $permission,
                'guard_name' => 'web',
            ]);
        }

        // ===== ROLES =====
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $user  = Role::firstOrCreate(['name' => 'user',  'guard_name' => 'web']);

        $admin->syncPermissions($permissions);
        $user->syncPermissions([
            'dashboard.view',
        ]);

        // ===== USERS =====
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name'     => 'Administrator',
                'password' => Hash::make('password'),
            ]
        );
        $adminUser->syncRoles('admin');

        $caesarUser = User::firstOrCreate(
            ['email' => 'ycaesar03@gmail.com'],
            [
                'name'     => 'Caesar',
                'password' => Hash::make('123123123'),
            ]
        );
        $caesarUser->syncRoles('admin');

        $regularUser = User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name'     => 'Regular User',
                'password' => Hash::make('password'),
            ]
        );
        $regularUser->syncRoles('user');
    }
}