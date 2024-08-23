<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    public function test_success_register(): void
    {
        $data = [
            'name' => fake()->name,
            'login' => fake()->unique()->userName,
            'email' => fake()->unique()->email,
            'password' => 'password',
            'password_confirmation' => 'password'
        ];

        $response = $this->post(route('user.register'), $data);

        $response->assertCreated();

        $response->assertJsonStructure([
            'id', 'name', 'email', 'subscribers',
            'publications', 'avatar'
        ]);

        $response->assertJson([
            'name' => Arr::get($data, 'name'),
            'email' => Arr::get($data, 'email'),
            'subscribers' => 0,
            'publications' => 0,
            'avatar' => null,
        ]);

        $this->assertDatabaseHas(User::class, [
            'id' => $response->json('id'),
            'name' => Arr::get($data, 'name'),
            'email' => Arr::get($data, 'email'),
            'login' => Arr::get($data, 'login'),
        ]);
    }

    public function test_register_validation() {
        $data = [
            'name' => '',
            'login' => '',
            'email' => 'arshidihgmail.com',
            'password' => 'dsafasdfsad'
        ];

        $response = $this->post(route('user.register'), $data);

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors(['name', 'login', 'email', 'password']);
    }
}
