<?php

namespace Tests\Feature\Comment;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteCommentTest extends TestCase
{
    public function test_delete_comment() {
        $user = $this->getUser();

        $post = Post::factory()->create(['user_id' => $user]);
        $comment = Comment::factory()->create(['user_id' => $user->id, 'post_id' => $post->id]);

        $response = $this->delete(route('comments.delete',['post' => $post, 'comment' => $comment]));

        $response->assertNoContent();
    }
}
