<?php

namespace App\Services\User;

use App\Data\User\LoginData;
use App\Data\User\RegisterData;
use App\Data\User\UpdatePrivacyData;
use App\Data\User\UpdateUserData;
use App\Enums\SubscribeState;
use App\Models\Subscription;
use App\Models\User;
use App\Services\StorageService;
use App\Traits\UsesAuthUser;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Optional;

class UserService
{
    use UsesAuthUser;

    public function __construct(
        protected StorageService $storage,
    ) {}

    public function store(RegisterData $data): ?User
    {
        return User::query()->create($data->toArray());
    }

    public function login(LoginData $data): ?string
    {
        if(!($data->email instanceof Optional)|| !($data->login instanceof Optional)) {
            if (auth()->guard('web')->attempt($data->toArray())) {
                /** @var User $user*/
                $user = auth()->user();
                $user->tokens()->delete();
                return $user->createToken('auth_token')->plainTextToken;
            }
        }

        return null;
    }

    public function update(UpdateUserData $data): User
    {
        $user = $this->currentUser();
        $user->update($data->toArray());

        return $user;
    }

    public function updateAvatar(UploadedFile $avatar): User
    {
        $user = $this->currentUser();

        $user->update([
            'avatar' => $this->storage->upload($avatar, 'avatar')
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
        $currentUser = $this->currentUser();

        return $currentUser->posts()->get();
    }

    public function updatePrivacy(UpdatePrivacyData $data): void
    {
        $user = $this->currentUser();
        if ($user->is_private != $data->is_private)
        {
            $user->update(['is_private' => true]);
        }
    }

    public function subscribe(User $user): SubscribeState
    {
        $exists = Subscription::query()
            ->whereUserId($user->id)
            ->whereSubscriberId(auth()->id())
            ->exists();

        if ($exists) {
            return SubscribeState::AlreadySubscribed;
        }

        Subscription::query()->create([
            'user_id' => $user->id,
            'subscriber_id' => auth()->id(),
        ]);

        return SubscribeState::Subscribed;
    }

    public function unsubscribe(User $user): SubscribeState
    {
        $subscription = Subscription::query()
            ->whereUserId($user->id)
            ->whereSubscriberId(auth()->id())
            ->first();

        if (!$subscription) {
            return SubscribeState::AlreadyUnsubscribed;
        }

        $subscription->delete();

        return SubscribeState::Unsubscribed;
    }

}
