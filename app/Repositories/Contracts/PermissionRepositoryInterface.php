<?php

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\Permission\Models\Permission;

interface PermissionRepositoryInterface
{
    /**
     * @param int $perPage
     * @param string $orderBy
     * @param string $direction
     * @return LengthAwarePaginator
     */
    public function allPaginated(int $perPage = 5, string $orderBy = 'created_at', string $direction = 'desc'): LengthAwarePaginator;

    /**
     * @param array $data
     * @return Permission
     */
    public function create(array $data): Permission;

    /**
     * @param Permission $permission
     * @param array $data
     * @return bool
     */
    public function update(Permission $permission, array $data): bool;

    /**
     * @param Permission $permission
     * @return bool
     */
    public function delete(Permission $permission): bool;

    /**
     * @param string $orderBy
     * @param string $direction
     * @return mixed
     */
    public function all(string $orderBy = 'name', string $direction = 'asc');
}
