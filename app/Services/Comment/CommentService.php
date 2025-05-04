<?php

namespace App\Services\Comment;

use App\Data\Post\CommentData;
use App\Traits\UsesAuthUser;
use App\Models\Comment;
use App\Models\Post;

class CommentService
{
    use UsesAuthUser;

    public function store(Post $post, CommentData $data): Comment {
        return $post->comments()->create([
            'comment' => $data->comment,
            'user_id' => auth()->id(),
        ]);

    }

    public function update(Comment $comment, CommentData $data): bool
    {
        $user = $this->currentUser();

        if ($user->id !== $comment->user_id) {
            return false;
        }

        $comment->update($data->toArray());

        return true;
    }

    public function delete(Comment $comment): bool
    {
        $user = $this->currentUser();

        if ($user->id !== $comment->user_id) {
            return false;
        }

        $comment->delete();

        return true;
    }
}
