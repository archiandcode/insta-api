<?php

namespace App\Data\User;

use Spatie\LaravelData\Data;

class RegisterData extends Data
{
    public function __construct(
        public string $name,
        public string $email,
        public string $login,
        public string $password,
    ) {}
}
