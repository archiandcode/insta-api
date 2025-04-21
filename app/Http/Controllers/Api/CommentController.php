<?php

namespace App\Http\Controllers\Api;

use App\Facades\Comment as CommentService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\AddCommentRequest;
use App\Http\Requests\Comment\UpdateCommentRequest;
use App\Http\Resources\Comment\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')
        ->except(['index']);
    }

    public function index(Post $post): AnonymousResourceCollection
    {
        return CommentResource::collection($post->comments);
    }

    public function store(Post $post, AddCommentRequest $request): CommentResource
    {
        return CommentService::store($post, $request->getData());
    }

    public function update(Post $post, Comment $comment, UpdateCommentRequest $request): CommentResource|JsonResponse
    {
        return CommentService::update($comment, $request->getData());
    }

    public function delete(Post $post, Comment $comment): Response|JsonResponse
    {
        return CommentService::delete($comment);
    }
}
