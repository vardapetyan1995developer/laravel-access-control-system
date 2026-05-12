<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Users / Create
            </h2>
            <a href="{{ route('users.index') }}" class="bg-slate-700 text-sm rounded-md text-white px-3 py-2">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('users.store') }}" method="post">
                        @csrf

                        <div>
                            <label for="name" class="text-lg font-medium">Name</label>
                            <div class="my-3">
                                <input type="text" name="name" class="border-gray-300 shadow-sm w-1/2 rounded-lg" id="name" placeholder="Name" value="{{ old('name') }}" autocomplete="off">
                                @error('name')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <label for="email" class="text-lg font-medium">Email</label>
                            <div class="my-3">
                                <input type="email" name="email" class="border-gray-300 shadow-sm w-1/2 rounded-lg" id="email" placeholder="Email" value="{{ old('email') }}" autocomplete="off">
                                @error('email')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <label for="password" class="text-lg font-medium">Password</label>
                            <div class="my-3">
                                <input type="password" name="password" class="border-gray-300 shadow-sm w-1/2 rounded-lg" id="password" placeholder="Email" value="{{ old('password') }}" autocomplete="off">
                                @error('password')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <label for="confirm-password" class="text-lg font-medium">Confirm Password</label>
                            <div class="my-3">
                                <input type="password" name="confirm_password" class="border-gray-300 shadow-sm w-1/2 rounded-lg" id="confirm-password" placeholder="Confirm your password" value="{{ old('confirm_password') }}" autocomplete="off">
                                @error('confirm_password')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        @can('create user roles')
                            <div class="grid grid-cols-4 mb-3">
                                @if($roles->isNotEmpty())
                                    @foreach($roles as $key => $role)
                                        <div class="mt-3">
                                            <input type="checkbox" class="rounded" name="role[]" id="role-{{ $role->id }}" value="{{ $role->name }}">
                                            <label for="role-{{ $role->id }}">{{ $role->name }}</label>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        @endcan

                        <button class="bg-slate-700 text-sm rounded-md text-white px-5 py-3">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
