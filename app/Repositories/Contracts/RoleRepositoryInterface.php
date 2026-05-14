<?php

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\Permission\Models\Role;

interface RoleRepositoryInterface
{
    /**
     * @param int $perPage
     * @param string $orderBy
     * @param string $direction
     * @return LengthAwarePaginator
     */
    public function allPaginated(int $perPage = 5, string $orderBy = 'name', string $direction = 'asc'): LengthAwarePaginator;

    /**
     * @param array $data
     * @return Role
     */
    public function create(array $data): Role;

    /**
     * @param Role $role
     * @param array $data
     * @return bool
     */
    public function update(Role $role, array $data): bool;

    /**
     * @param Role $role
     * @return bool
     */
    public function delete(Role $role): bool;

    /**
     * @param string $orderBy
     * @param string $direction
     * @return mixed
     */
    public function all(string $orderBy = 'name', string $direction = 'asc');

    /**
     * @param Role $role
     * @param array $permissions
     * @return void
     */
    public function syncPermissions(Role $role, array $permissions): void;
}
