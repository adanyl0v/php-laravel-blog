<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $post->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="mb-4">
                        <a href="{{ route('posts.index') }}" class="text-indigo-600 hover:text-indigo-900">
                            &larr; Back to the list
                        </a>
                        <a href="{{ route('posts.edit', $post) }}"
                           class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-yellow-300 focus:ring-offset-2 transition ease-in-out duration-150">
                            Modify
                        </a>
                    </div>

                    <p class="text-sm text-gray-600">
                        Author: {{ $post->user->name }} | {{ $post->created_at->format('d.m.Y H:i') }}
                    </p>

                    <div class="mt-6 prose max-w-none">
                        {!! nl2br(e($post->body)) !!}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
