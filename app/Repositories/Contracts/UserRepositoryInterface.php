<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
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
     * @return User
     */
    public function create(array $data): User;

    /**
     * @param User $user
     * @param array $data
     * @return bool
     */
    public function update(User $user, array $data): bool;

    /**
     * @param User $user
     * @return bool
     */
    public function delete(User $user): bool;

    /**
     * @param User $user
     * @param array $roles
     * @return void
     */
    public function syncRoles(User $user, array $roles): void;
}
