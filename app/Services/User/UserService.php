<?php

namespace App\Services\User;

use App\Data\User\LoginData;
use App\Data\User\RegisterData;
use App\Data\User\UpdateUserData;
use App\Http\Resources\User\CurrentUserResource;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Optional;

class UserService
{
    public function store(RegisterData $data): CurrentUserResource
    {
        return new CurrentUserResource(
            User::query()->create($data->toArray())
        );
    }

    public function login(LoginData $data): JsonResponse
    {
        if(!($data->email instanceof Optional)|| !($data->login instanceof Optional)) {
            if (auth()->guard('web')->attempt($data->toArray())) {
                /** @var User $user*/
                $user = auth()->user();
                $user->tokens()->delete();
                $token = $user->createToken('auth_token')->plainTextToken;

                return response()->json([
                    'token' => $token
                ]);
            }
        }

        return responseFailed('Invalid credentials', 401);
    }

    public function update(UpdateUserData $data): User
    {
        /** @var User $user*/
        $user = auth()->user();
        $user->update($data->toArray());

        return $user;
    }

    public function updateAvatar(UploadedFile $avatar): User
    {
        /** @var User $user*/
        $user = auth()->user();

        $user->update([
            'avatar' => uploadImage($avatar)
        ]);

        return $user;
    }

    public function posts(User $user): Collection
    {
        return $user
            ->posts()
            ->where('is_archived', '=', false)
            ->get();
    }

    public function currentUserPosts(): Collection
    {
        /** @var User $currentUser */
        $currentUser = auth()->user();

        return $currentUser->posts()->get();
    }
}
