<?php

namespace Comment;

use App\Models\Comment;
use App\Models\Post;
use Tests\TestCase;

class UpdateCommentTest extends TestCase
{
    public function test_update_comment() {
        $user = $this->getUser();

        /** @var Post $post */
        $post = Post::factory()->create(['user_id' => $user->id]);
        $comment = Comment::factory()->create(['user_id' => $user->id, 'post_id' => $post->id]);

        $data = [
            'comment' => 'Lol kek cheburek',
        ];

        $response = $this->patch(route('comments.update', ['post' => $post, 'comment' => $comment]), $data);

        $response->assertOk();

        $response->assertJsonStructure([
            'id', 'user', 'comment',
        ]);

    }
}
