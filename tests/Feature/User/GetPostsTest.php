<?php

namespace Tests\Feature\User;

use App\Models\Post;
use Tests\TestCase;

class GetPostsTest extends TestCase
{
    public function test_get_posts() {
        Post::factory(10)->create(['user_id' => $this->getUserId()]);

        Post::factory(10)->create([
            'user_id' => $this->getUserId(),
            'is_archived' => true,
            ]);

        $response = $this->get(route('users.posts', ['user' => $this->getUser()]));

        $response->assertOk();

        $response->assertJsonStructure([
            '*' => [
                'id',
                'photo'
            ]
        ]);

        $response->assertJsonCount(10);
    }
}
