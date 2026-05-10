<?php

namespace App\Http\Controllers;

use App\Helpers\Input;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * @return Renderable
     */
    public function index(): Renderable
    {
        $permissions = Permission::query()->orderByDesc('created_at')->paginate(10);

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
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'unique:permissions', 'min:3'],
        ]);

        if ($validator->passes())
        {
            Permission::query()->create([
                'name' => Input::filter($request->input('name')),
            ]);

            return redirect()->route('permissions.index')->with('success', 'Permission created successfully.');
        }
        else
        {
            return redirect()->route('permissions.create')->withInput()->withErrors($validator);
        }
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
     * @param Request $request
     * @param Permission $permission
     * @return RedirectResponse
     */
    public function update(Request $request, Permission $permission): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|unique:permissions,name,'. $permission->id . ',id'
        ]);

        if ($validator->passes())
        {
            $permission->update(['name' => $request->input('name')]);

            return redirect()->route('permissions.index')->with('success','Permission updated successfully');
        }
        else
        {
            return redirect()->route('permissions.edit', $permission)->withInput()->withErrors($validator);
        }
    }

    public function destroy()
    {

    }
}
