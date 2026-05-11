<?php

namespace App\Http\Controllers;

use App\Helpers\Input;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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
}
