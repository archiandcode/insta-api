<?php

namespace App\Facades;

use App\Services\User\UserService;
use Illuminate\Support\Facades\Facade;


/**
 * @method static \App\Models\User store(App\Data\User\RegisterData $data)
 * @method static \Illuminate\Http\JsonResponse login(App\Data\User\LoginData $data)
 * @method static \App\Models\User update(App\Data\User\UpdateUserData $data)
 * @method static \App\Models\User updateAvatar(Illuminate\Http\UploadedFile $avatar)
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
