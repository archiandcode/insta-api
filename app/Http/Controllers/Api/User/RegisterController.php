<?php

namespace App\Http\Controllers\Api\User;

use App\Facades\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Resources\User\CurrentUserResource;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request): CurrentUserResource
    {
        return User::store($request->data());
    }
}
