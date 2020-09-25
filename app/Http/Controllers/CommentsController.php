<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Post $post)
    {
        $data = request()->validate([
            'comment' => 'required',
        ]);

        auth()->user()->comments()->create([
            'post_id' => $post->id,
            'comment' => $data['comment'],
        ]);

        return redirect()->back();

    }
}
