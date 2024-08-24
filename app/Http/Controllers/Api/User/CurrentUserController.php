<?php

namespace App\Http\Controllers\Api\User;

use App\Facades\User as UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateAvatarRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\Post\AuthUserPostResource;
use App\Http\Resources\User\CurrentUserResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CurrentUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function user(): CurrentUserResource
    {
        return new CurrentUserResource(auth()->user());
    }

    public function update(UpdateUserRequest $request): CurrentUserResource
    {
        return new CurrentUserResource(
            UserService::update($request->data())
        );
    }

    public function avatar(UpdateAvatarRequest $request): CurrentUserResource
    {
        return new CurrentUserResource(
            UserService::updateAvatar($request->avatar())
        );
    }

    public function posts(): AnonymousResourceCollection
    {
        return AuthUserPostResource::collection(UserService::currentUserPosts());
    }
}
