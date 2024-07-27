<?php

namespace App\Http\Requests\Post;

use App\Http\Requests\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class AddCommentRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'comment' => 'required|string|max:255'
        ];
    }
}
