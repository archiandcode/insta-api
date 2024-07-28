<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\User */
class CurrentUserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name, 
            'email' => $this->email,
            'login' => $this->login,
            'subscribers' => $this->subscriptionsCount(),
            'publications' => $this->postsCount()
        ];
    }
}
