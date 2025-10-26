<?php

namespace Tests\Unit\Account;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UpdatePasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_password_unauthenticated(): void
    {
        $user = User::factory()->create();
        $newpassword = 'newpassword';
        $response = $this->putJson(self::$API_PREFIX . "user/$user->id/password/update", [
            'old_password' => 'password',
            'password' =>  $newpassword,
            'password_confirmation' =>  $newpassword
        ]);
        $response->assertStatus(401);
    }
    public function test_update_password_valid(): void
    {
        $user = User::factory()->create();
        $newpassword = 'newpassword';
        $token = $this->login($user->email, "password");
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->putJson(self::$API_PREFIX . "user/$user->id/password/update", [
                'old_password' => 'password',
                'password' =>  $newpassword,
                'password_confirmation' =>  $newpassword
            ]);
        $response->assertStatus(200);
        $userAfterUpdate = User::find($user->id);
        $this->assertTrue(Hash::check($newpassword, $userAfterUpdate->password));
    }
    public function test_update_password_wrong_password(): void
    {
        $user = User::factory()->create();
        $newpassword = 'newpassword';
        $token = $this->login($user->email, "password");
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->putJson(self::$API_PREFIX . "user/$user->id/password/update", [
                'old_password' => 'password-wrong',
                'password' =>  $newpassword,
                'password_confirmation' =>  $newpassword
            ]);
        $response->assertStatus(400)
            ->assertJson([
                'error' => "Invalid credentials"
            ]);
    }
    public function test_update_password_wrong_password_confirmation(): void
    {
        $user = User::factory()->create();
        $newpassword = 'newpassword';
        $token = $this->login($user->email, "password");
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->putJson(self::$API_PREFIX . "user/$user->id/password/update", [
                'old_password' => 'password',
                'password' =>  $newpassword,
                'password_confirmation' =>  $newpassword . "extra"
            ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['password']);
    }
}
