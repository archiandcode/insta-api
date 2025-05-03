<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait UsesAuthUser
{
    public function currentUser(): User
    {
        /** @var User */
        return Auth::user();
    }
}
