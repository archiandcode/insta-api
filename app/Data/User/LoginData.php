<?php

namespace App\Data\User;

use Spatie\LaravelData\Optional;
use Spatie\LaravelData\Data;

class LoginData extends Data
{
    public function __construct(
        public string|Optional $email,
        public string|Optional $login,
        public string $password,
    ) {}
}
