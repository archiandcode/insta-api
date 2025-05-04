<?php

namespace App\Http\Resources\Post;

use App\Http\Resources\User\MinifiedUserResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Post */
class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'photo' => $this->photo,
            'description' => $this->description,
            'user' => new MinifiedUserResource($this->user),
            'likes_count' => $this->likes()->count(),
            'comments_count' => $this->comments()->count(),
            'created_at' => Carbon::parse($this->created_at)->format('H:i d.m.Y'),
        ];
    }
}
