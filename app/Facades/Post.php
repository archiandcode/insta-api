<?php

namespace App\Facades;

use App\Services\Post\PostService;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Database\Eloquent\Collection index(\App\Models\User $user)
 * @method static \App\Models\Post store(\App\Data\Post\CreatePostData $data)
 * @method static bool update(\App\Models\Post $post, \App\Data\Post\UpdatePostData $data)
 * @method static bool delete(\App\Models\Post $post)
 * @method static \App\Enums\LikeState like(\App\Models\Post $post)
 * @method static \App\Enums\LikeState unlike(\App\Models\Post $post)
 *
 * @see PostService
 */
class Post extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return PostService::class;
    }
}
