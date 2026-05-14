<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class UserService
{
    private UserRepositoryInterface $userRepository;

    /**
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPaginatedUsers(int $perPage = 5): LengthAwarePaginator
    {
        return $this->userRepository->allPaginated($perPage);
    }

    /**
     * @param array $data
     * @param array $roles
     * @return User
     */
    public function createUser(array $data, array $roles = []): User
    {
        $data['password'] = Hash::make($data['password']);
        $user = $this->userRepository->create($data);

        if (!empty($roles) && auth()->user()->can('create user roles'))
        {
            $this->userRepository->syncRoles($user, $roles);
        }

        return $user;
    }

    /**
     * @param User $user
     * @param array $data
     * @param array $roles
     * @return bool
     */
    public function updateUser(User $user, array $data, array $roles = []): bool
    {
        if (isset($data['password']))
        {
            $data['password'] = Hash::make($data['password']);
        }

        $user->fill($data);

        if ($user->isDirty('email'))
        {
            $user->email_verified_at = null;
        }

        $updated = $user->save();

        if (auth()->check() && auth()->user()->can('edit user roles'))
        {
            $this->userRepository->syncRoles($user, $roles);
        }

        return $updated;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function deleteUser(User $user): bool
    {
        return $this->userRepository->delete($user);
    }
}
