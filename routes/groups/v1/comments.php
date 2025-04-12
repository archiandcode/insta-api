<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CommentController;

Route::controller(CommentController::class)
    ->prefix('posts')
    ->as('comments.')
    ->group(function() {
        Route::get('/{post}/comments', 'index')->name('index');
        Route::post('/{post}/comments', 'store')->name('store');
        Route::put('/{post}/comments/{comment}', 'update')->name('update');
        Route::delete('/{post}/comments/{comment}', 'delete')->name('delete');
    });

