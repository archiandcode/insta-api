<?php

namespace App\Facades;

use App\Services\Post\PostService;
use Illuminate\Support\Facades\Facade;


/**
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
