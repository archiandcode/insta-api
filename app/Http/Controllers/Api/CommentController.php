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
use Illuminate\Http\Response;

class CommentController extends Controller
{
    public function store(Post $post, AddCommentRequest $request): CommentResource
    {
        return CommentService::store($post, $request->data());
    }

    public function update(Post $post, Comment $comment, UpdateCommentRequest $request): CommentResource|JsonResponse
    {
        return CommentService::update($comment, $request->data());
    }

    public function delete(Post $post, Comment $comment): Response|JsonResponse
    {
        return CommentService::delete($comment);
    }
}
