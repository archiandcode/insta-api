<?php

namespace App\Facades;

use App\Services\User\UserService;
use Illuminate\Support\Facades\Facade;


/**
 * @method static \App\Models\User store(array $data)
 *
 * @see UserService;
 */
class User extends Facade
{
    public static function getFacadeAccessor()
    {
        return UserService::class;
    }
}
