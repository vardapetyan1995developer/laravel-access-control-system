<?php

namespace App\Services;

use App\Repositories\Contracts\PermissionRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\Permission\Models\Permission;

class PermissionService
{
    private PermissionRepositoryInterface $permissionRepository;

    /**
     * @param PermissionRepositoryInterface $permissionRepository
     */
    public function __construct(PermissionRepositoryInterface $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPaginatedPermissions(int $perPage = 5): LengthAwarePaginator
    {
        return $this->permissionRepository->allPaginated($perPage);
    }

    /**
     * @param array $data
     * @return Permission
     */
    public function createPermission(array $data): Permission
    {
        return $this->permissionRepository->create($data);
    }

    /**
     * @param Permission $permission
     * @param array $data
     * @return bool
     */
    public function updatePermission(Permission $permission, array $data): bool
    {
        return $this->permissionRepository->update($permission, $data);
    }

    /**
     * @param Permission $permission
     * @return bool
     */
    public function deletePermission(Permission $permission): bool
    {
        return $this->permissionRepository->delete($permission);
    }

    /**
     * @return mixed
     */
    public function getAllPermissions(): mixed
    {
        return $this->permissionRepository->all();
    }
}
