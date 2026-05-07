<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        // Fetch top-level posts; the replies relationship recursively eager-loads nested replies
        $query = Post::with('user', 'replies')->whereNull('parent_id')->latest();

        // Extra Challenge: Search Implementation
        if ($request->has('search') && $request->search != '') {
            $query->where('content', 'like', '%' . $request->search . '%');
        }

        // Handles your old pagination logic automatically
        $posts = $query->paginate(10);

        return view('posts.index', compact('posts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        // Replaces your old INSERT INTO SQL query
        Post::create([
            'user_id' => auth()->id(),
            'parent_id' => $request->parent_id,
            'content' => $request->message
        ]);

        $page = $request->input('current_page', 1);
        return redirect()->route('posts.index', ['page' => $page]);
    }

    public function destroy(Post $post)
    {
        // Authorization: Ensure the logged-in user owns the post before deleting
        if (auth()->id() === $post->user_id) {
            $post->delete(); 
        }

        return back();
    }
}