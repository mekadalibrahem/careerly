<?php

namespace Tests\Unit\Auth;

use App\Models\User;
use App\Modules\Users\Enums\UserRolesEnums;
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
        $response = $this->postJson(self::$API_PREFIX . 'register', [
            'name' => "testname",
            'email' => "testEmail@example.com",
            'role' => UserRolesEnums::USER(),
            'title' => "job title",
            'password' => "password",
            'password_confirmation' => 'password'

        ]);

        $response->assertStatus(201)
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
    public function test_create_user_invalid_email(): void
    {
        $response = $this->postJson(self::$API_PREFIX . 'register', [
            'name' => "testname",
            'email' => "testEmailexample.com",
            'password' => "password",
            'role' => UserRolesEnums::USER(),
            'title' => "job title",
            'password_confirmation' => 'password'

        ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }
    public function test_create_user_invalid_confirmation_password(): void
    {
        $response = $this->postJson(self::$API_PREFIX . 'register', [
            'name' => "testname",
            'email' => "testEmail@example.com",
            'password' => "password",
            'role' => UserRolesEnums::USER(),
            'title' => "job title",
            'password_confirmation' => 'password-diff'

        ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['password']);
    }
    public function test_create_user_exists_email(): void
    {
        $user = User::factory()->create();
        $this->assertDatabaseHas('users', [
            'email' => $user->email
        ]);
        $response = $this->postJson(self::$API_PREFIX . 'register', [
            'name' => "testname",
            'email' => $user->email,
            'password' => "password",
            'role' => UserRolesEnums::USER(),
            'title' => "job title",
            'password_confirmation' => 'password'

        ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }
    public function test_create_user_role_invalid(): void
    {

        $response = $this->postJson(self::$API_PREFIX . 'register', [
            'name' => "testname",
            'email' => "test@gmail.com",
            'password' => "password",
            'role' => "invalid role",
            'title' => "job title",
            'password_confirmation' => 'password'

        ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['role']);
    }
}
