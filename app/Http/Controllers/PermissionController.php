<?php

namespace App\Http\Controllers;

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
        return view('permissions.list');
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
                'name' => $request->input('name'),
            ]);

            return redirect()->route('permissions.index')->with('success', 'Permission created successfully.');
        }
        else
        {
            return redirect()->route('permissions.create')->withInput()->withErrors($validator);
        }
    }

    public function show()
    {

    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}
