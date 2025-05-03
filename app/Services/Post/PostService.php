<?php

namespace App\Services\Post;

use App\Data\Post\CreatePostData;
use App\Data\Post\UpdatePostData;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class PostService
{
    public function index(User $user): Collection
    {
        return $user->posts()->get();
    }

    public function store(CreatePostData $data): Model
    {
        $path = $data->photo->storePublicly('images');

        /** @var User $user */
        $user = auth()->user();

        return $user->posts()->create([
            'photo' => config('app.url') . Storage::url($path),
            'description' => $data->description,
        ]);
    }

    public function update(Post $post, UpdatePostData $data): PostResource|JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        if ($user->id !== $post->user_id) {
            return responseFailed('Unauthorized', 403);
        }

        $post->update($data->toArray());

        return new PostResource($post->refresh());
    }

    public function delete(Post $post): JsonResponse|Response
    {
        /** @var User $user */
        $user = auth()->user();

        if ($user->id !== $post->user_id) {
            return responseFailed('Unauthorized', 403);
        }

        $post->delete();

        return response()->noContent();
    }
}
