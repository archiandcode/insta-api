<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function getUser(User $user)
    {
        return response()->json($user, 200);
    }

    public function posts(User $user)
    {
        return response()->json($user->posts()->get());
    }

    public function subscribe(User $user)
    {
        return response()->json([
            'state' => $user->subscribe()
        ], 201);
    }

    public function subscriptions(User $user) {
        $subscriptions = Subscription::query()->whereSubscriberId($user->id)->get();
        return response()->json($subscriptions);        
    }

    public function subscribers(User $user) {
        $subscribers = Subscription::query()->whereUserId($user->id)->get();
        return response()->json($subscribers);
    }
}
