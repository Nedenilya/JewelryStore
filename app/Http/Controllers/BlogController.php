<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostLikes;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    function getPosts(Request $request): JsonResponse
    {
        $userId = $request->userId ?? 0;

        $posts = Post::where('is_active', 1)
            ->withCount('post_likes')
            ->with(['post_likes' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }])
            ->get()
            ->map(function ($post) use ($userId) {
                $post->liked = isset($post->post_likes[0]['user_id']);
                return $post;
            })
            ->toArray();

        return response()->json($posts);
    }

    function getCategories(): JsonResponse
    {
        $categories = PostCategory::where('is_active', 1)
            ->withCount('posts')
            ->get()
            ->toArray();

        return response()->json($categories);
    }

    function likePost(Request $request): JsonResponse
    {
        $request->validate([
            'postId' => 'required|integer|exists:posts,id',
            'userId' => 'required|integer|exists:users,id',
        ]);

        $postLike = PostLikes::where('post_id', $request->postId)
            ->where('user_id', $request->userId)->first();

        if(!$postLike){
            $postLike = PostLikes::create([
                'user_id' => $request->userId,
                'post_id' => $request->postId
            ]);
            $postLike->save();
            $message = 'liked';
        }else{
            $postLike->delete();
            $message = 'unliked';
        }

        $likesCount = $postLike->where('post_id', $request->postId)->get()->count();

        return response()->json([
            'message' => $message,
            'likesCount' => $likesCount
        ]);
    }
}
