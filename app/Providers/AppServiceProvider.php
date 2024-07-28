<?php

namespace App\Providers;

use App\Services\Post\PostService;
use App\Services\User\UserService;
use App\Http\Resources\User\UserResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserService::class, UserService::class);
        $this->app->bind(PostService::class, PostService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        UserResource::withoutWrapping();
    }
}
