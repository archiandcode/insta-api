<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory(50)
            ->has(
                Post::factory(3)
                    ->has(
                        Comment::factory(4)
                            ->for(User::factory())
                    )
                    ->has(
                        Like::factory(10)
                            ->for(User::factory())
                    )
            )->create();


        $users = User::all();

        foreach ($users as $user) {
            $randomUsers = User::query()
                ->inRandomOrder(rand(1, 30))
                ->get();

            $data = [];

            foreach ($randomUsers as $randomUser) {
                $data[] = [
                    'user_id' => $user->id,
                    'subscriber_id' => $randomUser->id,
                ];
            }

            Subscription::query()->insert($data);
        }
    }
}
