<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Articles / Show
            </h2>
            <a href="{{ route('articles.index') }}" class="bg-slate-700 text-sm rounded-md text-white px-3 py-2">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-500">Name</h3>
                        <div class="my-3 p-3 bg-gray-50 border border-gray-200 rounded-lg w-1/2">
                            {{ $article->name }}
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-500">Author</h3>
                        <div class="my-3 p-3 bg-gray-50 border border-gray-200 rounded-lg w-1/2">
                            {{ $article->author }}
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-500">Text</h3>
                        <div class="my-3 p-3 bg-gray-50 border border-gray-200 rounded-lg w-1/2">
                            {{ $article->text }}
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('articles.edit', $article) }}" class="bg-slate-700 text-sm rounded-md text-white px-5 py-3 inline-block">
                            Edit Article
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>