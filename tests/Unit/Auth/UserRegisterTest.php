<?php

namespace Tests\Unit\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRegisterTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     */
    public function test_valid_regester_new_user(): void
    {
        $respone = $this->postJson(self::$API_PREFIX . 'register', [
            'name' => "testname",
            'email' => "testEmail@example.com",
            'password' => "password",
            'password_confirmation' => 'password'

        ]);

        $respone->assertStatus(201)
            ->assertJson([
                "user" => [
                    'name' => "testname",
                    'email' => "testEmail@example.com",
                ]
            ]);

        $this->assertDatabaseHas('users', [
            'name' => "testname",
            'email' => "testEmail@example.com",
        ]);
    }
}
