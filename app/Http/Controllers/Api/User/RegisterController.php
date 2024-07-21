<?php

namespace App\Http\Controllers\Api\User;

use App\Facades\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\RegisterRequest;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request)
    {
        $user = User::store($request->validated());

        return response()->json([
            'id' => $user->id
        ], 201);
    }
}
