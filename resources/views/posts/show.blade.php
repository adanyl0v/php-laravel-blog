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

                    <hr class="my-6">
                    <div class="mt-6">
                        <h3 class="font-bold text-lg mb-2">Leave a comment</h3>

                        @if ($errors->any())
                            <div class="mb-4 p-4 bg-red-100 text-red-700 border border-red-200 rounded-md">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('posts.comments.store', $post) }}">
                            @csrf
                            <div class="mt-4">
                                <label for="body"
                                       class="block font-medium text-sm text-gray-700 sr-only">Comment</label>
                                <textarea id="body" name="body" rows="4"
                                          class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"
                                          placeholder="What do you think?">{{ old('body') }}</textarea>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Publish
                                </button>
                            </div>
                        </form>

                        <div class="mt-6">
                            <h3 class="font-bold text-lg mb-2">Comments</h3>

                            @forelse ($post->comments as $comment)
                                <div class="mb-4 p-4 border rounded-md bg-gray-50">
                                    <p class="text-sm font-semibold text-gray-800">
                                        {{ $comment->user->name }} </p>
                                    <p class="text-xs text-gray-500">
                                        {{ $comment->created_at->format('d.m.Y H:i') }}
                                    </p>
                                    <p class="mt-2 text-gray-700">
                                        {{ $comment->body }}
                                    </p>

                                    <div class="mt-2 flex items-center space-x-4">
                                        @can('update', $comment)
                                            <a href="{{ route('comments.edit', $comment) }}"
                                               class="text-sm text-yellow-600 hover:text-yellow-800">
                                                Edit
                                            </a>
                                        @endcan

                                        @can('delete', $comment)
                                            <form method="POST" action="{{ route('comments.destroy', $comment) }}"
                                                  class="m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="text-sm text-red-600 hover:text-red-800"
                                                        onclick="return confirm('Are you sure you want to delete this comment?')">
                                                    Delete
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </div>
                            @empty
                                <p>No comments yet. Be first!</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
