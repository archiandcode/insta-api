<?php

namespace App\Services\Comment;

use App\Data\Post\CommentData;
use App\Http\Resources\Comment\CommentResource;
use Illuminate\Http\JsonResponse;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Response;

class CommentService
{
    public function store(Post $post, CommentData $data): CommentResource {
        $comment = $post->comments()->create([
            'comment' => $data->comment,
            'user_id' => auth()->id(),
        ]);

        return new CommentResource($comment);
    }

    public function update(Comment $comment, CommentData $data): CommentResource|JsonResponse
    {
        /** @var User $user*/
        $user = auth()->user();

        if ($user->id !== $comment->user_id) {
            return responseFailed('Unauthorized', 403);
        }

        $comment->update($data->toArray());

        return new CommentResource($comment);
    }

    public function delete(Comment $comment): Response|JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        if ($user->id !== $comment->user_id) {
            return responseFailed('Unauthorized', 403);
        }

        return response()->noContent();
    }
}
