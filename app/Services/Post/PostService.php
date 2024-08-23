<?php

namespace App\Services\Post;

use App\Data\Post\UpdatePostData;
use App\Http\Requests\Post\PostStoreRequest;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Model;

class PostService
{
    public function store(PostStoreRequest $request): Model
    {

        $path = $request->file('photo')->storePublicly('images');

        /** @var \App\Models\User $user */
        $user = auth()->user();

        return $user->posts()->create([
            'photo' => config('app.url') . Storage::url($path),
            'description' => $request->str('description')
        ]);
    }

    public function update(Post $post, UpdatePostData $data): PostResource|JsonResponse
    {
        /** @var \App\Models\User $user*/
        $user = auth()->user();

        if ($user->id !== $post->user_id) {
            return responseFailed('Unauthorized', 403);
        }


        $post->update($data->toArray());

        return new PostResource($post);
    }

    public function delete(Post $post): JsonResponse|Response
    {
        /** @var \App\Models\User $user*/
        $user = auth()->user();

        if ($user->id !== $post->user_id) {
            return responseFailed('Unauthorized', 403);
        }

        $post->delete();
        return response()->noContent();
    }
}
