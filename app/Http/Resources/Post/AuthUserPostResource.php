<?php

namespace App\Http\Resources\Post;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


/** @mixin \App\Models\Post */
class AuthUserPostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'photo' => $this->photo,
            'description' => $this->description,
            'is_archived' => $this->is_archived,
        ];
    }
}
