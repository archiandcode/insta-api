<?php

namespace App\Data\Post;

use Spatie\LaravelData\Data;

class CommentData extends Data
{
    public function __construct(
        public string $comment
    ) {}
}
