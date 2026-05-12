@php
    use Carbon\Carbon;
@endphp
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Permissions') }}
            </h2>
            @can('create permissions')
                <a href="{{ route('permissions.create') }}" class="bg-slate-700 text-sm rounded-md text-white px-3 py-2">Create</a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <x-message></x-message>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                            <tr class="border-b">
                                <th class="px-6 py-3 text-left" width="60">#</th>
                                <th class="px-6 py-3 text-left">Name</th>
                                <th class="px-6 py-3 text-left" width="180">Created</th>
                                <th class="px-6 py-3 text-center" width="180">Action</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white">
                            @if($permissions->isNotEmpty())
                                @foreach($permissions as $key => $permission)
                                    <tr class="border-b">
                                        <td class="px-6 py-3 text-left">{{ $permission->id }}</td>
                                        <td class="px-6 py-3 text-left">{{ $permission->name }}</td>
                                        <td class="px-6 py-3 text-left">
                                            {{ Carbon::parse($permission->created_at)->format('d M, Y') }}
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            @can('edit permissions')
                                                <a href="{{ route('permissions.edit', $permission->id) }}"
                                                   class="bg-slate-500 text-sm rounded-md text-white px-3 py-2 hover:bg-slate-500">
                                                    Edit
                                                </a>
                                            @endcan

                                            @can('delete permissions')
                                                <a href="javascript:void(0);"
                                                   data-url="{{ route('permissions.delete', $permission->id) }}"
                                                   class="delete-permission bg-red-500 text-sm rounded-md text-white px-3 py-2 hover:bg-red-500 m-1">
                                                    Delete
                                                </a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="my-3">
                        {{ $permissions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script type="text/javascript">
            $(document).ready(function () {
                $(document).on('click', '.delete-permission', function (e) {
                    e.preventDefault();

                    let url = $(this).data('url');

                    if (confirm('Are you sure you want to delete?')) {
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (response) {
                                if (response.success) {
                                    // Reload to show the flash message correctly
                                    window.location.reload();
                                }
                            },
                            error: function (xhr) {
                                alert('Something went wrong. Please try again.');
                            }
                        });
                    }
                });
            });
        </script>
    </x-slot>
</x-app-layout>
