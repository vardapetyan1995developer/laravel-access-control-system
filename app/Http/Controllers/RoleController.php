<?php

namespace App\Http\Controllers;

use App\Helpers\Input;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\Routing\Attribute\Route;

class RoleController extends Controller
{
    /**
     * @return Renderable
     */
    public function index(): Renderable
    {
        $roles = Role::query()->orderBy('name')->paginate(5);

        return view('roles.list', compact('roles'));
    }

    /**
     * @return Renderable
     */
    public function create(): Renderable
    {
        $permissions = Permission::query()->orderBy('name')->get();

        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'unique:roles', 'min:3'],
        ]);

        if ($validator->passes())
        {
            $role = Role::query()->create([
                'name' => Input::filter($request->input('name')),
            ]);

            if (!empty($request->input('permission')))
            {
                foreach ($request->input('permission') as $permission)
                {
                    $role->givePermissionTo($permission);
                }
            }

            return redirect()->route('roles.index')->with('success', 'Role created successfully.');
        }
        else
        {
            return redirect()->route('roles.create')->withInput()->withErrors($validator);
        }
    }

    /**
     * @param Role $role
     * @return Renderable
     */
    public function edit(Role $role): Renderable
    {
        $hasPermissions = $role->permissions->pluck('name');
        $permissions = Permission::query()->orderBy('name')->get();

        return view('roles.edit', compact('role', 'hasPermissions', 'permissions'));
    }

    /**
     * @param Request $request
     * @param Role $role
     * @return RedirectResponse
     */
    public function update(Request $request, Role $role): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|unique:roles,name,'. $role->id . ',id'
        ]);

        if ($validator->passes())
        {
            $role->update(['name' => $request->input('name')]);

            if (!empty($request->input('permission')))
            {
                $role->syncPermissions($request->input('permission'));
            }
            else
            {
                $role->syncPermissions([]);
            }

            return redirect()->route('roles.index')->with('success', 'Role updated successfully');
        }
        else
        {
            return redirect()->route('roles.edit', $role)->withInput()->withErrors($validator);
        }
    }

    /**
     * @param Role $role
     * @return JsonResponse
     */
    public function destroy(Role $role): JsonResponse
    {
        $role->delete();

        session()->flash('success', 'Role deleted successfully');

        return response()->json([
            'success' => true,
        ]);
    }
}
