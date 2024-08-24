<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Post\MinifiedPostResource;
use App\Http\Resources\User\MinifiedUserResource;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Facades\User as UserService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function getUser(User $user): UserResource
    {
        return new UserResource($user);
    }

    public function posts(User $user): AnonymousResourceCollection
    {
        return MinifiedPostResource::collection(UserService::posts($user));
    }

    public function subscriptions(User $user): AnonymousResourceCollection
    {
        return MinifiedUserResource::collection($user->subscribedUsers()->get());
    }

    public function subscribers(User $user): AnonymousResourceCollection
    {
        return MinifiedUserResource::collection($user->subscribers()->get());
    }

    public function subscribe(User $user): JsonResponse
    {
        return response()->json([
            'state' => $user->subscribe()
        ], 201);
    }

}
