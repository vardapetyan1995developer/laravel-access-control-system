<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Users / Show
            </h2>

            <a href="{{ route('users.index') }}"
               class="bg-slate-700 text-sm rounded-md text-white px-3 py-2">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Name -->
                    <div class="mb-6">
                        <label class="text-lg font-medium text-gray-500">Name</label>

                        <div class="my-3 p-3 bg-gray-50 border border-gray-200 rounded-lg w-1/2">
                            {{ $user->name }}
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="mb-6">
                        <label class="text-lg font-medium text-gray-500">Email</label>

                        <div class="my-3 p-3 bg-gray-50 border border-gray-200 rounded-lg w-1/2">
                            {{ $user->email }}
                        </div>
                    </div>

                    <!-- Roles -->
                    <div class="mb-6">
                        <label class="text-lg font-medium text-gray-500">Roles</label>

                        <div class="grid grid-cols-4 mt-3">
                            @if($roles->isNotEmpty())
                                @foreach($roles as $role)
                                    <div class="mt-2 flex items-center gap-2">
                                        <input
                                            type="checkbox"
                                            class="rounded"
                                            disabled
                                            {{ $hasRoles->contains($role->id) ? 'checked' : '' }}
                                        >

                                        <span class="text-sm text-gray-700">
                                            {{ $role->name }}
                                        </span>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
