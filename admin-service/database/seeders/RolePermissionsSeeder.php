<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'dashboard show',

            'category create',
            'category edit',
            'category destroy',

            'sub-category create',
            'sub-category edit',
            'sub-category destroy',

            'catalog module',

            'product create',
            'product edit',
            'product show',
            'product destroy',

            'product policy create',
            'product policy edit',
            'product policy destroy',

            'order module',
            'order update',
            'order send',
            'order invoice download',

            'transaction module',
            'transaction detail',

            'acs module',
            'role create',
            'role edit',
            'role destroy',

            'permission create',
            'permission edit',
            'permission destroy',

            'user create',
            'user edit',
            'user destroy',

            'email module',
            'single email module',
            'multiple email module',
            'send single email',
            'send multiple email',

            'review create',
            'review edit',
            'review destroy',

            'app-info module',
            'app-info store',

            'mail-setting module',
            'mail-setting store',

            'payment gateway management',
            'cj token management',
            'shipping management module',

            'notification module',
            'notification delete',

            'page content management',

            'faq create',
            'faq edit',
            'faq destroy',

            'contact create',
            'contact manage',

            'banners create',
            'banners edit',
            'banners destroy',

            'app cache clear',
        ];

        $users = [
            0 => [
                'name' => 'Super Admin',
                'email' => 'hr.hridoykhan2020.mh@gmail.com',
                'password' => Hash::make('password'),
                'status' => 1,
                'email_verified_at' => now()
            ],
            1 => [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
                'phone' => '01799630233',
                'status' => 1,
                'email_verified_at' => now()
            ]
        ];

        $roles = ['super-admin', 'admin', 'guest'];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        foreach ($roles as $role) {
           $assignedRole = Role::firstOrCreate(['name' => $role]);

           if($assignedRole->name !== 'guest'){
            $assignedRole->syncPermissions($permissions);
           }
        }

        foreach ($users as $index => $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                $userData
            );

            if ($index === 0) {
                $user->assignRole('super-admin');
            } else {
                $user->assignRole('admin');
            }
        }
    }
}

