<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //
    public function store(Request $request, Post $post)
    {
        $validated = $this->validate($request, [
            'body' => 'required|string|max:5095',
        ]);

        $post->comments()->create([
            'user_id' => auth()->user()->id,
            'body' => $validated['body'],
        ]);

        return back()->with('status', 'Comment successfully posted!');
    }

    public function edit(Comment $comment)
    {
        $this->authorize('update', $comment);

        return view('comments.edit', compact('comment'));
    }

    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $validated = $this->validate($request, [
            'body' => 'required|string|max:5095',
        ]);
        $comment->update($validated);

        return redirect()
            ->route('posts.show', $comment->post_id)
            ->with('status', 'Comment successfully updated!');
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('update', $comment);

        $comment->delete();

        return back()->with('status', 'Comment successfully deleted!');
    }
}
