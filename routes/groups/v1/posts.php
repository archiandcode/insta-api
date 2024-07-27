<?php

use App\Http\Controllers\Api\PostController;
use Illuminate\Support\Facades\Route;

Route::controller(PostController::class)
    ->prefix('posts')
    ->as('posts.')
    ->group(function () {
        Route::post('/', 'create')->name('create');
        Route::delete('/{post}', 'delete')->name('delete');
        Route::post('/{post}/comments', 'addComment')->name('add-comment');
        Route::post('/{post}/like', 'like')->name('like');
    });
