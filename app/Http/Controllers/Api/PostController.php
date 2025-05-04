<?php

namespace App\Http\Controllers\Api;

use App\Facades\Post as PostService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\PostStoreRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;
use App\Traits\UsesApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class PostController extends Controller
{
    use UsesApiResponse;

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * @OA\Post(
     *     path="/api/v1/posts",
     *     summary="Create a new post",
     *     description="Create a new post with an image and description",
     *     tags={"Posts"},
     *     security={{"sanctum": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"description", "photo"},
     *                 @OA\Property(property="description", type="string", example="This is my new post"),
     *                 @OA\Property(property="photo", type="string", format="binary")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Post created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="photo", type="string", example="https://example.com/storage/images/photo.jpg"),
     *             @OA\Property(property="description", type="string", example="This is my new post"),
     *             @OA\Property(
     *                 property="user",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="John Doe"),
     *                 @OA\Property(property="avatar", type="string", example="https://example.com/storage/avatars/avatar.jpg")
     *             ),
     *             @OA\Property(property="likes_count", type="integer", example=0),
     *             @OA\Property(property="comments_count", type="integer", example=0),
     *             @OA\Property(property="created_at", type="string", example="12:34 27.04.2025")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function create(PostStoreRequest $request): PostResource
    {
        $post = PostService::store($request->getData());
        return new PostResource($post);
    }

    /**
     * @OA\Patch(
     *     path="/api/v1/posts/{post}",
     *     summary="Update an existing post",
     *     description="Update post's description",
     *     tags={"Posts"},
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="post",
     *         in="path",
     *         required=true,
     *         description="Post ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"description"},
     *             @OA\Property(property="description", type="string", example="Updated description")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="photo", type="string", example="https://example.com/storage/images/photo.jpg"),
     *             @OA\Property(property="description", type="string", example="Updated description"),
     *             @OA\Property(
     *                 property="user",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="John Doe"),
     *                 @OA\Property(property="avatar", type="string", example="https://example.com/storage/avatars/avatar.jpg")
     *             ),
     *             @OA\Property(property="likes_count", type="integer", example=5),
     *             @OA\Property(property="comments_count", type="integer", example=2),
     *             @OA\Property(property="created_at", type="string", example="12:34 27.04.2025")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function update(Post $post, UpdatePostRequest $request): JsonResponse|PostResource
    {
        if (PostService::update($post, $request->getData())) {
            return $this->responseFailed('Unauthorized', 403);
        }

        return response()->json(new PostResource($post->refresh()));
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/posts/{post}",
     *     summary="Delete a post",
     *     description="Delete a user's own post",
     *     tags={"Posts"},
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="post",
     *         in="path",
     *         required=true,
     *         description="Post ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Post deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthorized")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post not found"
     *     )
     * )
     */
    public function delete(Post $post): Response|JsonResponse
    {
        $success = PostService::delete($post);

        if (!$success) {
            return $this->responseFailed('Unauthorized', 403);
        }

        return response()->noContent();
    }

    /**
     * @OA\Post(
     *     path="/api/v1/posts/{post}/like",
     *     summary="Like or unlike a post",
     *     description="Toggle like status for a post. Returns current state.",
     *     tags={"Posts"},
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="post",
     *         in="path",
     *         required=true,
     *         description="Post ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post liked or unliked successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="state",
     *                 type="string",
     *                 enum={"liked", "unliked"},
     *                 example="liked"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post not found"
     *     )
     * )
     */
    public function like(Post $post): JsonResponse
    {
        return response()->json([
            'state' => $post->like()
        ]);
    }
}
