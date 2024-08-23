<?php

namespace App\Http\Requests\Post;

use App\Data\Post\UpdatePostData;
use App\Http\Requests\ApiRequest;

class UpdatePostRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'description' => 'required|string|max:255'
        ];
    }

    public function data(): UpdatePostData
    {
        return UpdatePostData::from($this->validated());
    }
}
