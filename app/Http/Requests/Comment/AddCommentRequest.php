<?php

namespace App\Http\Requests\Comment;

use App\Data\Post\CommentData;
use App\Http\Requests\ApiRequest;

class AddCommentRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'comment' => 'required|string|max:255'
        ];
    }

    public function getData(): CommentData {
        return CommentData::from($this->validated());
    }
}
