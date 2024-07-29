<?php

namespace App\Http\Requests\User;

use App\Data\User\LoginData;
use App\Http\Requests\ApiRequest;

class LoginRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            "email" => "required|string|email|exists:users,email",
            "password" => "required|string"
        ];
    }

    public function data() : LoginData {
        return LoginData::from($this->validated());
    }

}
