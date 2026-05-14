<?php

namespace App\Http\Controllers;

use App\Helpers\Input;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Services\PermissionService;
use App\Services\RoleService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Spatie\Permission\Models\Role;

class RoleController extends Controller implements HasMiddleware
{
    private RoleService $roleService;
    private PermissionService $permissionService;

    /**
     * @param RoleService $roleService
     * @param PermissionService $permissionService
     */
    public function __construct(RoleService $roleService, PermissionService $permissionService)
    {
        $this->roleService = $roleService;
        $this->permissionService = $permissionService;
    }

    /**
     * @return Middleware[]
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view roles', only: ['index']),
            new Middleware('permission:edit roles', only: ['edit']),
            new Middleware('permission:create roles', only: ['create']),
            new Middleware('permission:delete roles', only: ['destroy']),
        ];
    }

    /**
     * @return Renderable
     */
    public function index(): Renderable
    {
        $roles = $this->roleService->getPaginatedRoles();

        return view('roles.list', compact('roles'));
    }

    /**
     * @return Renderable
     */
    public function create(): Renderable
    {
        $permissions = $this->permissionService->getAllPermissions();

        return view('roles.create', compact('permissions'));
    }

    /**
     * @param StoreRoleRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRoleRequest $request): RedirectResponse
    {
        $this->roleService->createRole(
            ['name' => Input::filter($request->input('name'))],
            $request->input('permission', [])
        );

        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    /**
     * @param Role $role
     * @return Renderable
     */
    public function edit(Role $role): Renderable
    {
        $hasPermissions = $role->permissions->pluck('name');
        $permissions = $this->permissionService->getAllPermissions();

        return view('roles.edit', compact('role', 'hasPermissions', 'permissions'));
    }

    /**
     * @param UpdateRoleRequest $request
     * @param Role $role
     * @return RedirectResponse
     */
    public function update(UpdateRoleRequest $request, Role $role): RedirectResponse
    {
        $this->roleService->updateRole(
            $role,
            ['name' => $request->input('name')],
            $request->input('permission', [])
        );

        return redirect()->route('roles.index')->with('success', 'Role updated successfully');
    }

    /**
     * @param Role $role
     * @return JsonResponse
     */
    public function destroy(Role $role): JsonResponse
    {
        $this->roleService->deleteRole($role);

        session()->flash('success', 'Role deleted successfully');

        return response()->json([
            'success' => true,
        ]);
    }
}
