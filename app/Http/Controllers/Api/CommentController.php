<?php

namespace App\Http\Controllers\Api;

use App\Facades\Comment as CommentService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\AddCommentRequest;
use App\Http\Requests\Comment\UpdateCommentRequest;
use App\Http\Resources\Comment\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use App\Traits\UsesApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    use UsesApiResponse;

    public function __construct()
    {
        $this->middleware('auth:sanctum')
        ->except(['index']);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/posts/{post}/comments",
     *     summary="Get comments for a post",
     *     description="Returns a list of comments for a specific post",
     *     tags={"Comments"},
     *     @OA\Parameter(
     *         name="post",
     *         in="path",
     *         required=true,
     *         description="Post ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of comments",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=12),
     *                 @OA\Property(
     *                     property="user",
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=5),
     *                     @OA\Property(property="name", type="string", example="John Doe"),
     *                     @OA\Property(property="avatar", type="string", example="https://yourdomain.com/storage/avatars/avatar.jpg")
     *                 ),
     *                 @OA\Property(property="comment", type="string", example="Nice post!"),
     *                 @OA\Property(property="created_at", type="string", example="28/04/2025 14:30")
     *             )
     *         )
     *     )
     * )
     */
    public function index(Post $post): AnonymousResourceCollection
    {
        return CommentResource::collection($post->comments);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/posts/{post}/comments",
     *     summary="Add a comment to a post",
     *     description="Adds a new comment to a specific post",
     *     tags={"Comments"},
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="post",
     *         in="path",
     *         required=true,
     *         description="Post ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"comment"},
     *             @OA\Property(property="comment", type="string", example="This is a new comment")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Comment created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=12),
     *             @OA\Property(
     *                 property="user",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=5),
     *                 @OA\Property(property="name", type="string", example="John Doe"),
     *                 @OA\Property(property="avatar", type="string", example="https://yourdomain.com/storage/avatars/avatar.jpg")
     *             ),
     *             @OA\Property(property="comment", type="string", example="This is a new comment"),
     *             @OA\Property(property="created_at", type="string", example="28/04/2025 14:30")
     *         )
     *     )
     * )
     */
    public function store(Post $post, AddCommentRequest $request): CommentResource
    {
        $comment = CommentService::store($post, $request->getData());
        return new CommentResource($comment);

    }

    /**
     * @OA\Put(
     *     path="/api/v1/posts/{post}/comments/{comment}",
     *     summary="Update a comment",
     *     description="Updates an existing comment on a post",
     *     tags={"Comments"},
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="post",
     *         in="path",
     *         required=true,
     *         description="Post ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="comment",
     *         in="path",
     *         required=true,
     *         description="Comment ID",
     *         @OA\Schema(type="integer", example=10)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"comment"},
     *             @OA\Property(property="comment", type="string", example="Updated comment text")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Comment updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=12),
     *             @OA\Property(
     *                 property="user",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=5),
     *                 @OA\Property(property="name", type="string", example="John Doe"),
     *                 @OA\Property(property="avatar", type="string", example="https://yourdomain.com/storage/avatars/avatar.jpg")
     *             ),
     *             @OA\Property(property="comment", type="string", example="Updated comment text"),
     *             @OA\Property(property="created_at", type="string", example="28/04/2025 14:30")
     *         )
     *     )
     * )
     */
    public function update(Post $post, Comment $comment, UpdateCommentRequest $request): CommentResource|JsonResponse
    {
        if (CommentService::update($comment, $request->getData())) {
            return $this->responseFailed('Unauthorized', 403);
        }

        return response()->json(new CommentResource($comment));
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/posts/{post}/comments/{comment}",
     *     summary="Delete a comment",
     *     description="Deletes a comment from a post",
     *     tags={"Comments"},
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="post",
     *         in="path",
     *         required=true,
     *         description="Post ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="comment",
     *         in="path",
     *         required=true,
     *         description="Comment ID",
     *         @OA\Schema(type="integer", example=10)
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Comment deleted successfully"
     *     )
     * )
     */
    public function delete(Post $post, Comment $comment): Response|JsonResponse
    {
        if (CommentService::delete($comment)) {
            return $this->responseFailed('Unauthorized', 403);
        }

        return response()->noContent();
    }
}
