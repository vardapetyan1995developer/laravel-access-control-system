<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @param int $perPage
     * @param string $orderBy
     * @param string $direction
     * @return LengthAwarePaginator
     */
    public function allPaginated(int $perPage = 5, string $orderBy = 'created_at', string $direction = 'desc'): LengthAwarePaginator
    {
        return User::query()->orderBy($orderBy, $direction)->paginate($perPage);
    }

    /**
     * @param array $data
     * @return User
     */
    public function create(array $data): User
    {
        return User::query()->create($data);
    }

    /**
     * @param User $user
     * @param array $data
     * @return bool
     */
    public function update(User $user, array $data): bool
    {
        return $user->update($data);
    }

    /**
     * @param User $user
     * @return bool
     */
    public function delete(User $user): bool
    {
        return $user->delete();
    }

    /**
     * @param User $user
     * @param array $roles
     * @return void
     */
    public function syncRoles(User $user, array $roles): void
    {
        $user->syncRoles($roles);
    }
}
