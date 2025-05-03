<?php

namespace App\Http\Requests\User;

use App\Data\User\UpdatePrivacyData;
use App\Http\Requests\ApiRequest;

class UpdatePrivacyRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'is_private' => 'required|boolean',
        ];
    }

    public function getData(): UpdatePrivacyData
    {
        return UpdatePrivacyData::from($this->validated());
    }
}
