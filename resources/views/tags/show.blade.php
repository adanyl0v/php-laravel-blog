<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Posts by tag: #{{ $tag->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @forelse ($posts as $post)
                        <div class="mb-4 p-4 border rounded-md">
                            <h3 class="font-bold text-lg">{{ $post->title }}</h3>
                            <p class="text-sm text-gray-600">
                                Author: {{ $post->user->name }} | {{ $post->created_at->format('d.m.Y H:i') }}
                            </p>
                            <p class="mt-2">
                                {{ Str::limit($post->body, 150) }}
                            </p>
                            <div class="mt-3">
                                @forelse ($post->tags as $tag)
                                    <a href="{{ route('tags.show', $tag->slug) }}"
                                       class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2 hover:bg-gray-300">
                                        #{{ $tag->name }}
                                    </a>
                                @empty
                                @endforelse
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('posts.show', $post) }}"
                                   class="text-indigo-600 hover:text-indigo-900">
                                    Read more...
                                </a>
                            </div>
                        </div>
                    @empty
                        <p>No posts yes.</p>
                    @endforelse

                    <div class="mt-4">
                        {{ $posts->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
