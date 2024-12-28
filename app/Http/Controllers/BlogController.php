<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    function getPosts(): JsonResponse
    {
        $products = Post::where('is_active', 1)->get()->toArray();

        return response()->json($products);
    }

    function getCategories(): JsonResponse
    {
        $categories = PostCategory::where('is_active', 1)
            ->withCount('posts')
            ->get()
            ->toArray();

        return response()->json($categories);
    }
}
