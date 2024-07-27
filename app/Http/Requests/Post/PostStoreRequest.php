<?php

namespace App\Http\Requests\Post;

use App\Http\Requests\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class PostStoreRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'description' => 'required|string|max:255',
            'photo' => 'required|image|max:10240', // 10MB limit for the image size
        ];
    }
}
