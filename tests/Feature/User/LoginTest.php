<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_success_auth_with_email(): void {
        $response = $this->post(route('user.login'), [
            'email' => $this->user->email,
            'password' => 'password',
        ]);

        $response->assertOk();

        $response->assertJsonStructure(['token']);
    }

    public function test_success_auth_with_login():void {
        $response = $this->post(route('user.login'), [
            'login' => $this->user->login,
            'password' => 'password'
        ]);

        $response->assertOk();

        $response->assertJsonStructure(['token']);
    }

    public function test_failed_auth_with_invalid_password(): void {
        $response = $this->post(route('user.login'), [
            'email' => $this->user->email,
            'password' => 'incorrect_password',
        ]);

        $response->assertUnauthorized();

        $response->assertJson([
            'message' => 'Invalid credentials'
        ]);
    }

    public function test_failed_auth_with_invalid_login_or_email(): void {
        $response = $this->post(route('user.login'), [
            'email' => 'invalid@gmail.com',
            'password' => 'password',
        ]);

        $response->assertUnauthorized();

        $response->assertJson([
            'message' => 'Invalid credentials'
        ]);
    }

    public function test_failed_auth_with_missing_login_or_email():void {
        $response = $this->post(route('user.login'), [
            'password' => 'password',
        ]);

        $response->assertUnauthorized();

        $response->assertJson([
            'message' => 'Invalid credentials'
        ]);
    }

    public function test_login_validation(): void
    {
        $response = $this->post(route('user.login'), [
            'email' => $this->user->email
        ]);

        $response->assertUnprocessable();

        $response->assertJsonValidationErrorFor('password');
    }
}
