<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissionsMap = [
            'permissions' => ['view', 'edit', 'create', 'delete'],
            'roles'       => ['view', 'edit', 'create', 'delete'],
            'users'       => ['view', 'edit', 'create', 'delete'],
            'articles'    => ['view', 'edit', 'create', 'delete'],
            'user roles'    => ['edit', 'create'],
        ];

        collect($permissionsMap)->each(function (array $actions, string $entity): void
        {
            foreach ($actions as $action)
            {
                Permission::query()->firstOrCreate([
                    'name' => "{$action} {$entity}",
                    'guard_name' => 'web',
                ]);
            }
        });
    }
}
