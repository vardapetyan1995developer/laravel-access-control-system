<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Users / Edit
            </h2>
            <a href="{{ route('users.index') }}" class="bg-slate-700 text-sm rounded-md text-white px-3 py-2">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('users.update', $user) }}" method="post">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label for="name" class="text-lg font-medium">Name</label>
                            <div class="my-3">
                                <input type="text" name="name" class="border-gray-300 shadow-sm w-1/2 rounded-lg" id="name" placeholder="Enter Name" value="{{ old('name', $user->name) }}">
                                @error('name')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <label for="email" class="text-lg font-medium">Email</label>
                            <div class="my-3">
                                <input type="email" name="email" class="border-gray-300 shadow-sm w-1/2 rounded-lg" id="email" placeholder="Email" value="{{ old('email', $user->email) }}">
                                @error('email')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-4 mb-3">
                            @if($roles->isNotEmpty())
                                @foreach($roles as $key => $role)
                                    <div class="mt-3">
                                        <input type="checkbox" {{ $hasRoles->contains($role->id) ? 'checked' : '' }} class="rounded" name="role[]" id="role-{{ $role->id }}" value="{{ $role->name }}">
                                        <label for="role-{{ $role->id }}">{{ $role->name }}</label>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <button class="bg-slate-700 text-sm rounded-md text-white px-5 py-3">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
