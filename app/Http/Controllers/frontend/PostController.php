<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Topic;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request, $slug = null)
    {
        $topics = Topic::all();

        if ($slug) {
            $topic = Topic::where('slug', $slug)->first();
            $posts = $topic ? $topic->posts()->paginate(10) : Post::paginate(10);
        } else {
            $posts = Post::paginate(10);
        }

        return view('frontend.post', compact('posts', 'topics'));
    }

    public function detail($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        $relatedPosts = Post::where('topic_id', $post->topic_id)
            ->where('slug', '!=', $slug)
            ->take(5)
            ->get();
        return view('frontend.post-detail', compact('post', 'relatedPosts'));
    }
}
