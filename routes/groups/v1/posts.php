<?php

use App\Http\Controllers\Api\PostController;
use Illuminate\Support\Facades\Route;

Route::controller(PostController::class)
    ->prefix('posts')
    ->as('posts.')
    ->group(function () {
        Route::post('/', 'create')->name('create');
        Route::patch('/{post}', 'update')->name('update');
        Route::delete('/{post}', 'delete')->name('delete');
        Route::post('/{post}/like', 'like')->name('like');
    });
