<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Validator;

class UserController extends Controller implements HasMiddleware
{
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
        $users = User::query()->latest()->paginate(5);

        return view('users.list', compact('users'));
    }

    public function create(): Renderable
    {
        $roles = Role::query()->orderBy('name')->get();

        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3',
            'email' => ['required', 'min:3', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:5', 'same:confirm_password'],
        ]);

        if ($validator->passes())
        {
            $user = User::query()->create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);

            if (auth()->user()->can('create user roles'))
            {
                $user->syncRoles($request->input('role'));
            }

            return redirect()->route('users.index')->with('success', 'User updated successfully');
        }
        else
        {
            return redirect()->route('users.create')->withInput()->withErrors($validator);
        }
    }

    /**
     * @param User $user
     * @return Renderable
     */
    public function show(User $user): Renderable
    {
        $roles = Role::query()->orderBy('name')->get();
        $hasRoles = $user->roles()->pluck('id');

        return view('users.show', compact('user', 'roles', 'hasRoles'));
    }

    /**
     * @param User $user
     * @return Renderable
     */
    public function edit(User $user): Renderable
    {
        $roles = Role::query()->orderBy('name')->get();
        $hasRoles = $user->roles()->pluck('id');

        return view('users.edit', compact('user', 'roles', 'hasRoles'));
    }

    /**
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3',
            'email' => ['required', 'min:3', 'email', 'unique:users,email,'. $user->id . ',id'],
        ]);

        if ($validator->passes())
        {
            $user->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
            ]);

            if (auth()->user()->can('edit user roles'))
            {
                $user->syncRoles($request->input('role'));
            }

            return redirect()->route('users.index')->with('success', 'User updated successfully');
        }
        else
        {
            return redirect()->route('users.edit', $user)->withInput()->withErrors($validator);
        }
    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        session()->flash('success', 'User deleted successfully');

        return response()->json([
            'success' => true,
        ]);
    }
}
