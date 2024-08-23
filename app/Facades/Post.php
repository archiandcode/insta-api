<?php

namespace App\Facades;


use App\Services\Post\PostService;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Database\Eloquent\Model store(\App\Http\Requests\Post\PostStoreRequest $request)
 * @method static \App\Http\Resources\Post\PostResource|\Illuminate\Http\JsonResponse update(\App\Models\Post $post, \App\Data\Post\UpdatePostData $data)
 * @method static \Illuminate\Http\JsonResponse|\Illuminate\Http\Response delete(\App\Models\Post $post)
 *
 * @see PostService;
 */
class Post extends Facade
{
    public static function getFacadeAccessor()
    {
        return PostService::class;
    }
}
