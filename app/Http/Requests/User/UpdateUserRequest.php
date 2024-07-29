<?php

namespace App\Http\Requests\User;

use App\Data\User\UpdateUserData;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'nullable|max:255',
            'email' => 'nullable|email|unique:users,email|max:255',
            'login' => 'nullable|unique:users,login|max:255',
            'password' => 'nullable|min:6|max:255|confirmed',
        ];
    }

    public function data(): UpdateUserData {
        return UpdateUserData::from($this->validated());
    }
}
