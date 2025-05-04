<?php

namespace App\Facades;

use App\Services\Comment\CommentService;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \App\Models\Comment store(\App\Models\Post $post, \App\Data\Post\CommentData $data)
 * @method static bool update(\App\Models\Comment $comment, \App\Data\Post\CommentData $data)
 * @method static bool delete(\App\Models\Comment $comment)
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
