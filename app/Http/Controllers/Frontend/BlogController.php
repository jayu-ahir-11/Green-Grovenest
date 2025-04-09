<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blogs;


class BlogController extends Controller
{
    // Show all blogs on frontend
    public function index()
    {
        $blogs = Blogs::orderBy('created_at', 'desc')->get();
        return view('frontend.blogs.index', compact('blogs'));
    }

    // Show single blog on frontend
    public function show($slug)
    {
        $blog = Blogs::where('slug', $slug)->first();
        if (!$blog) {
            abort(404);
        }
        return view('frontend.blogs.show', compact('blog'));
    }
}
