<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function store(array $data): User
    {
        return User::query()->create([
            'name' => $data['name'],
            "login" => $data['login'],
            "email" => $data['email'],
            "password" => $data['password'],
        ]);
    }

    public function login(array $data) {
        $user = User::query()->where('email', $data['email'])->first();


        if ($user && Hash::check($data['password'], $user->password)) {
            $user->tokens()->delete();

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'token' => $token
            ]);
        }
        return responseFailed('Invalid credentials', 401);
    }
}
