<?php

namespace App\Http\Controllers;

use App\Helpers\Input;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Services\PermissionService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller implements HasMiddleware
{
    private PermissionService $permissionService;

    /**
     * @param PermissionService $permissionService
     */
    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    /**
     * @return Middleware[]
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view permissions', only: ['index']),
            new Middleware('permission:edit permissions', only: ['edit']),
            new Middleware('permission:create permissions', only: ['create']),
            new Middleware('permission:delete permissions', only: ['destroy']),
        ];
    }

    /**
     * @return Renderable
     */
    public function index(): Renderable
    {
        $permissions = $this->permissionService->getPaginatedPermissions();

        return view('permissions.list', compact('permissions'));
    }

    /**
     * @return Renderable
     */
    public function create(): Renderable
    {
        return view('permissions.create');
    }

    /**
     * @param StorePermissionRequest $request
     * @return RedirectResponse
     */
    public function store(StorePermissionRequest $request): RedirectResponse
    {
        $this->permissionService->createPermission([
            'name' => Input::filter($request->input('name')),
        ]);

        return redirect()->route('permissions.index')->with('success', 'Permission created successfully.');
    }

    /**
     * @param Permission $permission
     * @return Renderable
     */
    public function edit(Permission $permission): Renderable
    {
        return view('permissions.edit', compact('permission'));
    }

    /**
     * @param UpdatePermissionRequest $request
     * @param Permission $permission
     * @return RedirectResponse
     */
    public function update(UpdatePermissionRequest $request, Permission $permission): RedirectResponse
    {
        $this->permissionService->updatePermission($permission, [
            'name' => $request->input('name')
        ]);

        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully');
    }

    /**
     * @param Permission $permission
     * @return JsonResponse
     */
    public function destroy(Permission $permission): JsonResponse
    {
        $this->permissionService->deletePermission($permission);

        session()->flash('success', 'Permission deleted successfully');

        return response()->json([
            'success' => true,
        ]);
    }
}
