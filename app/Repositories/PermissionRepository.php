<?php

namespace App\Repositories;

use App\Repositories\Contracts\PermissionRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Permission;

class PermissionRepository implements PermissionRepositoryInterface
{
    /**
     * @param int $perPage
     * @param string $orderBy
     * @param string $direction
     * @return LengthAwarePaginator
     */
    public function allPaginated(int $perPage = 5, string $orderBy = 'created_at', string $direction = 'desc'): LengthAwarePaginator
    {
        return Permission::query()->orderBy($orderBy, $direction)->paginate($perPage);
    }

    /**
     * @param array $data
     * @return Permission
     */
    public function create(array $data): Permission
    {
        return Permission::query()->create($data);
    }

    /**
     * @param Permission $permission
     * @param array $data
     * @return bool
     */
    public function update(Permission $permission, array $data): bool
    {
        return $permission->update($data);
    }

    /**
     * @param Permission $permission
     * @return bool
     */
    public function delete(Permission $permission): bool
    {
        return $permission->delete();
    }

    /**
     * @param string $orderBy
     * @param string $direction
     * @return Collection
     */
    public function all(string $orderBy = 'name', string $direction = 'asc'): Collection
    {
        return Permission::query()->orderBy($orderBy, $direction)->get();
    }
}
