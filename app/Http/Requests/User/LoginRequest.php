<?php

namespace App\Http\Requests\User;

use App\Data\User\LoginData;
use App\Http\Requests\ApiRequest;

class LoginRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            "login" => "nullable|string|max:255",
            "email" => "nullable|email|max:255",
            "password" => "required|string"
        ];
    }

    public function getData() : LoginData {
        return LoginData::from($this->validated());
    }

}
