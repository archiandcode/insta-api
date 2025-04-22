<?php

namespace Tests\Feature\Post;

use Tests\TestCase;

class DeletePostTest extends TestCase
{
    public function test_delete_post()
    {
        $user = $this->getUser();

        /** @var \App\Models\Post $post */
        $post = $user->posts()->create();

        $response = $this->actingAs($user)->delete(route('posts.delete', $post));

        $response->assertNoContent();
    }
}
