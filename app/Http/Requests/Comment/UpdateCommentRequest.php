<?php

namespace App\Http\Requests\Comment;

use App\Data\Post\CommentData;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCommentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'comment' => 'required|string|max:255'
        ];
    }

    public function data(): CommentData {
        return CommentData::from($this->validated());
    }
}
