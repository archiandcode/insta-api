<?php

namespace Tests\Feature\Post;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class CreatePostTest extends TestCase
{
    public function test_create_post() {
        $user = $this->getUser();
        $image = UploadedFile::fake()->image('post.jpg');

        $response  = $this->actingAs($user)->post(route('posts.create'), [
            'photo' => $image,
            'description' => 'description for post'
        ]);

        $response->assertCreated();

        $response->assertJsonStructure([
            'id',
            'photo',
            'description',
            'user',
            'comments_count',
            'likes_count',
            'created_at'
        ]);
    }

    public function test_comments_and_likes_count() {
        $user = $this->getUser();

        /** @var Post $post */
        $post = $user->posts()->create();

        $post->comments()->create();

        $this->assertEquals(1, $post->commentsCount());

        $post->likes()->create(['user_id' => $user->id]);

        $this->assertEquals(1, $post->likesCount());
    }

}
