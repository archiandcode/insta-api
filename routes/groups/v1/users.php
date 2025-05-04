<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\User\UserController;

Route::controller(UserController::class)
    ->prefix('users')
    ->as('users.')
    ->group(function () {
        Route::get('/{user}', 'getUser');
        Route::get('/{user}/posts', 'posts');
        Route::post('/{user}/subscribe', 'subscribe');

        Route::get('/{user}/subscriptions', 'subscriptions');
        Route::get('/{user}/subscribers', 'subscribers');
    });
