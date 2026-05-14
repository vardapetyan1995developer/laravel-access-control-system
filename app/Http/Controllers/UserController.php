<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\RoleService;
use App\Services\UserService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class UserController extends Controller implements HasMiddleware
{
    private UserService $userService;
    private RoleService $roleService;

    /**
     * @param UserService $userService
     * @param RoleService $roleService
     */
    public function __construct(UserService $userService, RoleService $roleService)
    {
        $this->userService = $userService;
        $this->roleService = $roleService;
    }

    /**
     * @return Middleware[]
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view users', only: ['index']),
            new Middleware('permission:edit users', only: ['edit']),
            new Middleware('permission:create users', only: ['create']),
            new Middleware('permission:delete users', only: ['destroy']),
        ];
    }

    /**
     * @return Renderable
     */
    public function index(): Renderable
    {
        $users = $this->userService->getPaginatedUsers();

        return view('users.list', compact('users'));
    }

    public function create(): Renderable
    {
        $roles = $this->roleService->getAllRoles();

        return view('users.create', compact('roles'));
    }

    /**
     * @param StoreUserRequest $request
     * @return RedirectResponse
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $this->userService->createUser(
            $request->only(['name', 'email', 'password']),
            $request->input('role', [])
        );

        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    /**
     * @param User $user
     * @return Renderable
     */
    public function show(User $user): Renderable
    {
        $roles = $this->roleService->getAllRoles();
        $hasRoles = $user->roles()->pluck('id');

        return view('users.show', compact('user', 'roles', 'hasRoles'));
    }

    /**
     * @param User $user
     * @return Renderable
     */
    public function edit(User $user): Renderable
    {
        $roles = $this->roleService->getAllRoles();
        $hasRoles = $user->roles()->pluck('id');

        return view('users.edit', compact('user', 'roles', 'hasRoles'));
    }

    /**
     * @param UpdateUserRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $this->userService->updateUser(
            $user,
            $request->only(['name', 'email']),
            $request->input('role', [])
        );

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        $this->userService->deleteUser($user);

        session()->flash('success', 'User deleted successfully');

        return response()->json([
            'success' => true,
        ]);
    }
}
