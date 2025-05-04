<?php

namespace App\Services\Post;

use App\Data\Post\CreatePostData;
use App\Data\Post\UpdatePostData;
use App\Models\Post;
use App\Models\User;
use App\Traits\UsesAuthUser;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class PostService
{
    use UsesAuthUser;

    public function index(User $user): Collection
    {
        return $user->posts()->get();
    }

    public function store(CreatePostData $data): Model
    {
        $path = $data->photo->storePublicly('images');

        $user = $this->currentUser();

        return $user->posts()->create([
            'photo' => config('app.url') . Storage::url($path),
            'description' => $data->description,
        ]);
    }

    public function update(Post $post, UpdatePostData $data): bool
    {
        $user = $this->currentUser();

        if ($user->id !== $post->user_id) {
            return false;
        }

        return $post->update($data->toArray());
    }

    public function delete(Post $post): bool
    {
        $user = $this->currentUser();

        if ($user->id !== $post->user_id) {
            return false;
        }

        return $post->delete();
    }
}
