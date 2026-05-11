@php
    use Carbon\Carbon;
@endphp
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Roles') }}
            </h2>
            <a href="{{ route('roles.create') }}" class="bg-slate-700 text-sm rounded-md text-white px-3 py-2">Create</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <x-message></x-message>



                    <div class="my-3">
                        {{--{{ $roles->links() }}--}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script type="text/javascript">
            $(document).ready(function() {
                $(document).on('click', '.delete-role', function(e) {
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
                            error: function(xhr) {
                                alert('Something went wrong. Please try again.');
                            }
                        });
                    }
                });
            });
        </script>
    </x-slot>
</x-app-layout>
