<?php

namespace App\Facades;

use App\Services\Comment\CommentService;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \App\Http\Resources\Comment\CommentResource store(\App\Models\Post $post, \App\Data\Post\CommentData $data)
 * @method static \App\Http\Resources\Comment\CommentResource|\Illuminate\Http\JsonResponse update(\App\Models\Comment $comment, \App\Data\Post\CommentData $data)
 * @method static \Illuminate\Http\Response|\Illuminate\Http\JsonResponse delete(\App\Models\Comment $comment)
 *
 * @see CommentService
 */
class Comment extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return CommentService::class;
    }
}
