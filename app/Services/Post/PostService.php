<?php

namespace App\Services\Post;

use App\Http\Requests\Post\PostStoreRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class PostService
{
    public function posts()
    {
        /** @var \App\Models\User $user*/
        $user = auth()->user();

        return $user->posts()->get();
    }

    public function store(PostStoreRequest $request)
    {

        $path = $request->file('photo')->storePublicly('images');

        /** @var \App\Models\User $user */
        $user = auth()->user();

        return $user->posts()->create([
            'photo' => config('app.url') . Storage::url($path),
            'description' => $request->str('description')
        ]);
    }

    public function delete(Post $post) {
        /** @var \App\Models\User $user*/
        $user = auth()->user();

        if ($user->id !== $post->user_id) {
            return responseFailed('Unauthorized', 403);
        }

        $post->delete();
        return response()->json([
            'status' => 'success'
        ]);
    }
}
