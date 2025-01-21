<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostLikes;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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
                $post->liked = isset($post->post_likes[0]['user_id']) && $post->post_likes[0]['user_id'] == $userId;
                return $post;
            })
            ->toArray();

        return response()->json($posts);
    }

    function getResentPosts(): JsonResponse
    {
        $posts = Post::where('is_active', 1)
            ->orderBy('created_at','desc')
            ->limit(3)
            ->get()
            ->toArray();

        return response()->json([
            'recentPosts' => $posts
        ]);
    }

    function getPostById(Request $request): JsonResponse
    {
        $request->validate([
            'postId' => 'required|integer'
        ]);
        $postId = $request->postId;
        $previousPostId = Post::where('id', '<', $request->postId)
            ->orderBy('id', 'desc')
            ->first(['id']);

        $post = Post::where('id', $request->postId)
            ->first()
            ->toArray();

        $nextPostId = Post::where('id', '>', $request->postId)
            ->orderBy('id', 'asc')
            ->first(['id']);

        return response()->json([
            'post' => $post,
            'prevPostId' => $previousPostId['id'] ?? null,
            'nextPostId' => $nextPostId['id'] ?? null,
        ]);
    }

    function getCategories(): JsonResponse
    {
        $categories = PostCategory::where('is_active', 1)
            ->withCount('posts')
            ->get()
            ->toArray();

        return response()->json($categories);
    }

    function getLastNews(Request $request): JsonResponse
    {
        $userId = $request->userId ?? 0;

        $posts = Post::where('is_active', 1)
            ->with(['post_likes' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }])
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get()
            ->map(function ($post) use ($userId) {
                $post->liked = isset($post->post_likes[0]['user_id']) && $post->post_likes[0]['user_id'] == $userId;
                return $post;
            })
            ->toArray();

        return response()->json($posts);
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
