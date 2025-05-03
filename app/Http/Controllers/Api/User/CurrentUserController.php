<?php

namespace App\Http\Controllers\Api\User;

use App\Facades\User as UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateAvatarRequest;
use App\Http\Requests\User\UpdatePrivacyRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\Post\AuthUserPostResource;
use App\Http\Resources\User\CurrentUserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CurrentUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * @OA\Get(
     *     path="/api/v1/profile",
     *     summary="Get current user profile",
     *     description="Returns information about the authenticated user",
     *     tags={"Profile"},
     *     security={{"sanctum": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Current user data",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", example="john@example.com"),
     *             @OA\Property(property="login", type="string", example="john_doe"),
     *             @OA\Property(property="subscribers", type="integer", example=100),
     *             @OA\Property(property="publications", type="integer", example=50),
     *             @OA\Property(property="avatar", type="string", example="https://yourdomain.com/storage/avatars/avatar.jpg")
     *         )
     *     )
     * )
     */
    public function user(): CurrentUserResource
    {
        return new CurrentUserResource(auth()->user());
    }

    /**
     * @OA\Patch(
     *     path="/api/v1/profile",
     *     summary="Update current user profile",
     *     description="Updates the authenticated user's profile information",
     *     tags={"Profile"},
     *     security={{"sanctum": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *             @OA\Property(property="login", type="string", example="john_doe"),
     *             @OA\Property(property="password", type="string", format="password", example="newpassword123"),
     *             @OA\Property(property="password_confirmation", type="string", format="password", example="newpassword123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Profile updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="John Doe Updated"),
     *             @OA\Property(property="email", type="string", example="newjohn@example.com"),
     *             @OA\Property(property="login", type="string", example="john_doe_updated"),
     *             @OA\Property(property="subscribers", type="integer", example=100),
     *             @OA\Property(property="publications", type="integer", example=50),
     *             @OA\Property(property="avatar", type="string", example="https://yourdomain.com/storage/avatars/avatar.jpg")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The email field must be a valid email address."),
     *             @OA\Property(property="errors", type="object", example={"email": {"The email field must be a valid email address."}})
     *         )
     *     )
     * )
     */
    public function update(UpdateUserRequest $request): CurrentUserResource
    {
        return new CurrentUserResource(
            UserService::update($request->getData())
        );
    }

    /**
     * @OA\Post(
     *     path="/api/v1/profile/avatar",
     *     summary="Upload or update user avatar",
     *     description="Uploads a new avatar for the authenticated user",
     *     tags={"Profile"},
     *     security={{"sanctum": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"avatar"},
     *                 @OA\Property(
     *                     property="avatar",
     *                     type="string",
     *                     format="binary",
     *                     description="Avatar image file (jpeg or png, max 1MB)"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Avatar updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", example="john@example.com"),
     *             @OA\Property(property="login", type="string", example="john_doe"),
     *             @OA\Property(property="subscribers", type="integer", example=100),
     *             @OA\Property(property="publications", type="integer", example=50),
     *             @OA\Property(property="avatar", type="string", example="https://yourdomain.com/storage/avatars/new_avatar.jpg")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The avatar must be a file of type: jpeg, png."),
     *             @OA\Property(property="errors", type="object", example={"avatar": {"The avatar must be a file of type: jpeg, png."}})
     *         )
     *     )
     * )
     */
    public function avatar(UpdateAvatarRequest $request): CurrentUserResource
    {
        return new CurrentUserResource(
            UserService::updateAvatar($request->avatar())
        );
    }

    public function updatePrivacy(UpdatePrivacyRequest $request): JsonResponse
    {
        UserService::updatePrivacy($request->getData());
        return response()->json([
            'status'  => 'success',
            'message' => 'Privacy setting updated successfully',
        ]);
    }

    public function posts(): AnonymousResourceCollection
    {
        return AuthUserPostResource::collection(UserService::currentUserPosts());
    }
}
