<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Facades\Post as PostFacade;
use App\Http\Requests\Post\AddCommentRequest;
use App\Http\Requests\Post\PostStoreRequest;
use App\Models\Post;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    
    public function index() {
        $posts = PostFacade::posts();
        return response()->json($posts);
    }

    public function create(PostStoreRequest $request) {
        $post = PostFacade::store($request);
        return response()->json($post);
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
