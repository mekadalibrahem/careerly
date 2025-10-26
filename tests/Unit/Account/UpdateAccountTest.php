<?php

namespace Tests\Unit\Account;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateAccountTest extends TestCase
{
    use RefreshDatabase;
    public function test_update_account_unauthenticated()
    {
        $user = User::factory()->create();
        $response = $this->putJson(self::$API_PREFIX . "user/$user->id/update", [
            'name' => "newName",
            "email" => "newEmail@gmail.local"
        ]);
        $response->assertStatus(401);
    }

    public function test_update_account_valid()
    {
        $user = User::factory()->create();
        $token = $this->login($user->email, 'password');
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->putJson(self::$API_PREFIX . "user/$user->id/update", [
                'name' => "newName",
                "email" => "newEmail@gmail.local"
            ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => "newName",
            "email" => "newEmail@gmail.local"
        ]);
    }
    public function test_update_account_invalid_email()
    {
        $user = User::factory()->create();
        $token = $this->login($user->email, 'password');
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->putJson(self::$API_PREFIX . "user/$user->id/update", [
                'name' => "newName",
                "email" => "newEmailgmail.local"
            ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }
    public function test_update_account_existis_email()
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();
        $token = $this->login($user->email, 'password');
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->putJson(self::$API_PREFIX . "user/$user->id/update", [
                'name' => "newName",
                "email" => $user2->email
            ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }
}
