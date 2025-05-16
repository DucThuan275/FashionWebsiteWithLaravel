<?php

namespace App\View\Components;

use App\Models\Post;
use Illuminate\View\Component;

class PostNew extends Component
{
    public $latestPosts;

    public function __construct()
    {
        $this->latestPosts = Post::where('status', 1)
            ->orderBy('created_at', 'DESC')
            ->take(3)
            ->get();
    }

    public function render()
    {
        return view('components.post-new', ['posts' => $this->latestPosts]);
    }
}
