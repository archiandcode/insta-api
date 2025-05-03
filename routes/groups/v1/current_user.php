<?php

use App\Http\Controllers\Api\User\RegisterController;
use App\Http\Controllers\Api\User\LoginController;
use App\Http\Controllers\Api\User\CurrentUserController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'user', 'as' => 'user.'], function() {
    Route::post('/register', RegisterController::class)->name('register');
    Route::post('/login', LoginController::class)->name('login');

    Route::controller(CurrentUserController::class)
        ->prefix('/profile')
        ->group(function () {
        Route::get('/', 'user')->name('current');
        Route::patch('/', 'update')->name('update');
        Route::post('/avatar', 'avatar')->name('avatar');
        Route::patch('/privacy', 'updatePrivacy')->name('privacy.update');
        });
});
