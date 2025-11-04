<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with(['user', 'tags'])->latest()->paginate(10);

        return view('posts.index', compact('posts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $post = auth()->user()->posts()->create([
            'title' => $validated['title'],
            'body' => $validated['body'],
        ]);

        if (! empty($validated['tags'])) {
            $post->tags()->sync($validated['tags']);
        }

        return redirect()->route('posts.show', $post);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tags = Tag::orderBy('name')->get();

        return view('posts.create', compact('tags'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post->load(['user', 'comments.user', 'tags']);

        return view('posts.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        $tags = Tag::orderBy('name')->get();

        return view('posts.edit', [
            'post' => $post,
            'tags' => $tags,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $post->update([
            'title' => $validated['title'],
            'body' => $validated['body'],
        ]);

        $post->tags()->sync($validated['tags'] ?? []);

        return redirect()->route('posts.show', $post->id)->with('status', 'Post successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return redirect()->route('posts.index')->with('status', 'Post successfully deleted!');
    }
}
