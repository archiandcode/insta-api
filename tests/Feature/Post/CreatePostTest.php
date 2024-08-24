<?php

namespace Tests\Feature\Post;

use App\Models\Post;
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

    public function test_create_post_with_invalid_data() {
        $user = $this->getUser();

        $response  = $this->actingAs($user)->post(route('posts.create'), [
            'description' => ''
        ]);

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors(['photo', 'description']);
    }

    public function test_update_post() {
        $user = $this->getUser();
        $post = Post::factory()->create(['user_id' => $user]);

        $data = ['description' => 'asdfadsf sdaf safd dfsa fa ds'];
        $response = $this->patch(route('posts.update', $post), $data);

        $response->assertOk();
    }

    public function test_update_post_with_invalid_data() {
        $user = $this->getUser();

        $post = Post::factory()->create(['user_id' => $user]);

        $data = ['description' => ''];

        $response = $this->patch(route('posts.update', $post), $data);

        $response->assertUnprocessable();
    }
}
