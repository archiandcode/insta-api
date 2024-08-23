<?php

namespace Tests\Feature\Post;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdatePostTest extends TestCase
{
    public function test_failed_update() {
        $user = $this->getUser();

        $post = $user->posts()->create();

        $data = [
            'description' => 'dafs adsf asd fsad'
        ];

        $response = $this->patch(route('posts.update', $post), $data);

        $response->assertOk();

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
}
