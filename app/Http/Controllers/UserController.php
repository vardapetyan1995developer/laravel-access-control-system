<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @return Renderable
     */
    public function index(): Renderable
    {
        return view('users.list');
    }

    public function create(): Renderable
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        //
    }

    /**
     * @param User $user
     * @return Renderable
     */
    public function show(User $user): Renderable
    {
        return view('users.show', compact('user'));
    }

    /**
     * @param User $user
     * @return Renderable
     */
    public function edit(User $user): Renderable
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        //
    }

    public function destroy(User $user)
    {
        //
    }
}
