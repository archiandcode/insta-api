<?php

namespace App\Http\Resources\Comment;

use App\Http\Resources\User\MinifiedUserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Comment */
class CommentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => new MinifiedUserResource($this->user),
            'comment' => $this->comment,
            'created_at' => $this->created_at->format('d/m/Y H:i'),
        ];
    }
}
