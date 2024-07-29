<?php

namespace App\Services\User;

use App\Data\User\LoginData;
use App\Data\User\RegisterData;
use App\Data\User\UpdateUserData;
use App\Http\Resources\User\CurrentUserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;

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
        $user = User::query()->where('email', $data->email)->first();


        if ($user && Hash::check($data->password, $user->password)) {
            $user->tokens()->delete();

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'token' => $token
            ]);
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

    public function updateAvatar(UploadedFile $avatar)
    {
        /** @var User $user*/
        $user = auth()->user();

        $user->update([
            'avatar' => uploadImage($avatar)
        ]);

        return $user;
    }
}
