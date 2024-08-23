<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Facades\Post as PostFacade;
use App\Http\Requests\Post\AddCommentRequest;
use App\Http\Requests\Post\PostStoreRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;
use Illuminate\Http\Response;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function create(PostStoreRequest $request) {
        $post = PostFacade::store($request);
        return new PostResource($post);
    }

    public function update(Post $post, UpdatePostRequest $request) {
        return PostFacade::update($post, $request->data());
    }

    public function delete(Post $post) {
        return PostFacade::delete($post);
    }

    public function addComment(Post $post, AddCommentRequest $request) {
        $post->comments()->create([
            'comment' => $request->input('comment'),
            'user_id' => auth()->id(),
        ]);

        return response()->json([
            'status' => 'success'
        ], 201);
    }

    public function like(Post $post) {
        return response()->json([
            'state' => $post->like()
        ]);
    }
}
