<?php

namespace App\Data\Post;

use Spatie\LaravelData\Data;
use Illuminate\Http\UploadedFile;

class CreatePostData extends Data
{
    public function __construct(
        public UploadedFile $photo,
        public string $description,
    ){}
}
