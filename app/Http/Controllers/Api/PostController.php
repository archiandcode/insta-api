<?php

namespace App\Http\Controllers\Api;

use App\Facades\Post as PostService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\PostStoreRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function create(PostStoreRequest $request): PostResource
    {
        $post = PostService::store($request->data());
        return new PostResource($post);
    }

    public function update(Post $post, UpdatePostRequest $request): JsonResponse|PostResource
    {
        return PostService::update($post, $request->data());
    }

    public function delete(Post $post): Response|JsonResponse
    {
        return PostService::delete($post);
    }

    public function like(Post $post): JsonResponse
    {
        return response()->json([
            'state' => $post->like()
        ]);
    }
}
