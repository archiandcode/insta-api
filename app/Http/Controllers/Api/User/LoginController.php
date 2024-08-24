<?php

namespace App\Http\Controllers\Api\User;

use App\Facades\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use Illuminate\Http\JsonResponse;
class LoginController extends Controller
{
    public function __invoke(LoginRequest $request): JsonResponse
    {
        return User::login($request->data());
    }

}
