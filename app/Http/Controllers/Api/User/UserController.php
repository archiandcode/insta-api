<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateAvatarRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\CurrentUserResource;
use App\Http\Resources\User\MinifiedUserResource;
use App\Http\Resources\User\UserResource;
use App\Models\Subscription;
use App\Models\User;
use App\Facades\User as UserFacade;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function user() {
        return new CurrentUserResource(auth()->user());
    }

    public function getUser(User $user)
    {
        return new UserResource($user);
    }

    public function posts(User $user)
    {
        return response()->json($user->posts()->get());
    }

    public function update(UpdateUserRequest $request) {
        return new CurrentUserResource(
            UserFacade::update($request->data())
        );
    }

    public function subscribe(User $user)
    {
        return response()->json([
            'state' => $user->subscribe()
        ], 201);
    }

    public function subscriptions(User $user) {
        return MinifiedUserResource::collection($user->subscribedUsers()->get());
    }

    public function subscribers(User $user) {
        return MinifiedUserResource::collection($user->subscribers()->get());
    }

    public function avatar(UpdateAvatarRequest $request) {
        return new CurrentUserResource(
            UserFacade::updateAvatar($request->avatar())
        );
    }
}
