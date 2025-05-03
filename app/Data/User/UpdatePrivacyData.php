<?php

namespace App\Data\User;


use Spatie\LaravelData\Data;

class UpdatePrivacyData extends Data
{
    public function __construct(
        public bool $is_private,
    ) {}
}
