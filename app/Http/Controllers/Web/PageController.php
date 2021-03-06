<?php

namespace App\Http\Controllers\Web;

use App\Category;
use App\Http\Controllers\Controller;
use App\Post;
use App\Tag;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function blog()
    {
        $posts = Post::orderBy('id', 'DESC')->where('status', 'PUBLISHED')->paginate(8);

        return view('web.posts', compact('posts'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->pluck('id')->first();
        $posts = Post::where('category_id', $category)
                ->orderBy('id', 'DESC')->where('status', 'PUBLISHED')->paginate(6);
        return view('web.posts', compact('posts'));
    }

    public function tag($slug)
    {
        $posts = Post::whereHas('tags', function($query) use($slug) {
            $query->where('slug', $slug);
        })->orderBy('id', 'DESC')->where('status', 'PUBLISHED')->paginate(6);
        return view('web.posts', compact('posts'));
    }

    public function post($slug)
    {
        $post = Post::where('slug', $slug)->first();

        return view('web.post', compact('post'));
    }
}
