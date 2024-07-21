<?php

namespace App\Services\User;

use App\Models\User;

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
}
