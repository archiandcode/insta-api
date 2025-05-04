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
use OpenApi\Annotations as OA;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * @OA\Get(
     *     path="/api/v1/users/{user}",
     *     summary="Get user profile",
     *     description="Returns detailed profile information of a user",
     *     tags={"Users"},
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         required=true,
     *         description="User ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User profile data"
     *     )
     * )
     */
    public function getUser(User $user): UserResource
    {
        return new UserResource($user);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/users/{user}/posts",
     *     summary="Get user's posts",
     *     description="Returns a list of posts created by a user",
     *     tags={"Users"},
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         required=true,
     *         description="User ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of user's posts"
     *     )
     * )
     */
    public function posts(User $user): AnonymousResourceCollection
    {
        return MinifiedPostResource::collection(UserService::posts($user));
    }

    /**
     * @OA\Get(
     *     path="/api/v1/users/{user}/subscriptions",
     *     summary="Get user's subscriptions",
     *     description="Returns a list of users the specified user is subscribed to",
     *     tags={"Users"},
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         required=true,
     *         description="User ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of subscriptions"
     *     )
     * )
     */
    public function subscriptions(User $user): AnonymousResourceCollection
    {
        return MinifiedUserResource::collection($user->following()->get());
    }

    /**
     * @OA\Get(
     *     path="/api/v1/users/{user}/subscribers",
     *     summary="Get user's subscribers",
     *     description="Returns a list of users who subscribed to the specified user",
     *     tags={"Users"},
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         required=true,
     *         description="User ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of subscribers"
     *     )
     * )
     */
    public function subscribers(User $user): AnonymousResourceCollection
    {
        return MinifiedUserResource::collection($user->followers()->get());
    }

    /**
     * @OA\Post(
     *     path="/api/v1/users/{user}/subscribe",
     *     summary="Subscribe to a user",
     *     description="Subscribe to the specified user",
     *     tags={"Users"},
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         required=true,
     *         description="User ID to subscribe to",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Subscribed successfully"
     *     )
     * )
     */
    public function subscribe(User $user): JsonResponse
    {
        return response()->json([
            'state' => UserService::subscribe($user),
        ], 201);
    }
}
