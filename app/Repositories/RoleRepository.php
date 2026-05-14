<?php

namespace App\Repositories;

use App\Repositories\Contracts\RoleRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Role;

class RoleRepository implements RoleRepositoryInterface
{
    /**
     * @param int $perPage
     * @param string $orderBy
     * @param string $direction
     * @return LengthAwarePaginator
     */
    public function allPaginated(int $perPage = 5, string $orderBy = 'name', string $direction = 'asc'): LengthAwarePaginator
    {
        return Role::query()->orderBy($orderBy, $direction)->paginate($perPage);
    }

    /**
     * @param array $data
     * @return Role
     */
    public function create(array $data): Role
    {
        return Role::query()->create($data);
    }

    /**
     * @param Role $role
     * @param array $data
     * @return bool
     */
    public function update(Role $role, array $data): bool
    {
        return $role->update($data);
    }

    /**
     * @param Role $role
     * @return bool
     */
    public function delete(Role $role): bool
    {
        return $role->delete();
    }

    /**
     * @param string $orderBy
     * @param string $direction
     * @return Collection
     */
    public function all(string $orderBy = 'name', string $direction = 'asc'): Collection
    {
        return Role::query()->orderBy($orderBy, $direction)->get();
    }

    /**
     * @param Role $role
     * @param array $permissions
     * @return void
     */
    public function syncPermissions(Role $role, array $permissions): void
    {
        $role->syncPermissions($permissions);
    }
}
