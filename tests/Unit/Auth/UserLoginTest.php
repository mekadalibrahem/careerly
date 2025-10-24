<?php

namespace Tests\Unit\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserLoginTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     */
    public function test_valid_login(): void
    {
        $user = User::factory()->create();
        $this->assertDatabaseHas('users', [
            'email' => $user->email
        ]);
        $response = $this->postJson(self::$API_PREFIX . 'login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $response->assertStatus(200)
            ->assertJson([
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email
                ]
            ]);
    }

    public function test_login_with_wrong_password(): void
    {
        $user = User::factory()->create();
        $this->assertDatabaseHas('users', [
            'email' => $user->email
        ]);
        $response = $this->postJson(self::$API_PREFIX . 'login', [
            'email' => $user->email,
            'password' => 'password-wrong',
        ]);
        $response->assertStatus(400)
            ->assertJson([
                'error' => "Invalid credentials"
            ]);
    }
}
