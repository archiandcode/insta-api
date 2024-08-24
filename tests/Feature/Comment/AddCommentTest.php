<?php

namespace Tests\Feature\Comment;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddCommentTest extends TestCase
{
    public function test_add_comment() {
        $post = $this->getUser()->posts()->create();

        $response = $this->post(route('comments.store', $post), [
            'comment' => 'dasf adsf s '
        ]);

        $response->assertCreated();

        $response->assertJsonStructure([
            'id', 'user', 'comment',
        ]);
    }
}
