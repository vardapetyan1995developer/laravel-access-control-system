<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rolesConfig = [
            'superadmin' => [
                'name'     => 'Super Admin',
                'email'    => 'superadmin@example.com',
                'password' => 'superadmin',
            ],
            'admin' => [
                'name'     => 'Admin',
                'email'    => 'admin@example.com',
                'password' => 'adminadmin',
            ],
            'moderator' => [
                'name'     => 'Moderator',
                'email'    => 'moderator@example.com',
                'password' => 'moderator',
            ],
        ];

        foreach ($rolesConfig as $roleName => $userData)
        {
            $role = Role::query()->firstOrCreate(['name' => $roleName]);

            $user = User::query()->updateOrCreate(
                ['email' => $userData['email']],
                [
                    'name'     => $userData['name'],
                    'password' => Hash::make($userData['password']),
                ]
            );

            $user->assignRole($role);
        }
    }
}
