<?php

namespace App\Services;

use App\Repositories\Contracts\RoleRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\Permission\Models\Role;

class RoleService
{
    private RoleRepositoryInterface $roleRepository;

    /**
     * @param RoleRepositoryInterface $roleRepository
     */
    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPaginatedRoles(int $perPage = 5): LengthAwarePaginator
    {
        return $this->roleRepository->allPaginated($perPage);
    }

    /**
     * @param array $data
     * @param array $permissions
     * @return Role
     */
    public function createRole(array $data, array $permissions = []): Role
    {
        $role = $this->roleRepository->create($data);

        if (!empty($permissions))
        {
            $this->roleRepository->syncPermissions($role, $permissions);
        }

        return $role;
    }

    /**
     * @param Role $role
     * @param array $data
     * @param array $permissions
     * @return bool
     */
    public function updateRole(Role $role, array $data, array $permissions = []): bool
    {
        $updated = $this->roleRepository->update($role, $data);
        $this->roleRepository->syncPermissions($role, $permissions);

        return $updated;
    }

    /**
     * @param Role $role
     * @return bool
     */
    public function deleteRole(Role $role): bool
    {
        return $this->roleRepository->delete($role);
    }

    /**
     * @return mixed
     */
    public function getAllRoles(): mixed
    {
        return $this->roleRepository->all();
    }
}
