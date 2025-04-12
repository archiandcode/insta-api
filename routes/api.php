<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    require __DIR__ . '/groups/v1/current_user.php';
    require __DIR__ . '/groups/v1/posts.php';
    require __DIR__ . '/groups/v1/users.php';
    require __DIR__ . '/groups/v1/comments.php';
});

