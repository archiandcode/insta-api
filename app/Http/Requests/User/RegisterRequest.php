<?php

namespace App\Http\Requests\User;

use App\Data\User\RegisterData;
use App\Http\Requests\ApiRequest;

class RegisterRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            "name" => "required|string|max:255",
            "login" => "required|string|max:255|unique:users,login",
            "email" => "required|string|max:255|email|unique:users,email",
            "password" => "required|string|confirmed|min:8",
        ];
    }

    public function data() : RegisterData {
        return RegisterData::from($this->validated());
    }
}
