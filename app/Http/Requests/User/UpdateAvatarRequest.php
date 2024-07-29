<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

class UpdateAvatarRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'avatar' => ['required', 'mimes:jpeg,png', 'max:1000'],
        ];
    }

    public function avatar(): UploadedFile
    {
        return $this->file('avatar');
    }
}
