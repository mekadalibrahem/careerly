<?php

namespace Tests\Unit\Qaulifications;

use App\Models\User;
use App\Modules\Users\Enums\UserRolesEnums;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreSkillTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_skill_valid(): void
    {
        $user = User::factory()->create();
        $token = $this->login($user->email, 'password');
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->postJson(
            self::$API_PREFIX . "user/$user->id/skills",
            [
                'name' => "name",
            ]
        );
        $response->assertStatus(201);
    }
    public function test_create_skill_unauthenticated(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson(
            self::$API_PREFIX . "user/$user->id/skills",
            [
                'name' => "name",
            ]
        );
        $response->assertStatus(401);
    }
    public function test_create_skill_invalid_name_required(): void
    {
        $user = User::factory()->create();
        $token = $this->login($user->email, 'password');
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->postJson(
            self::$API_PREFIX . "user/$user->id/skills"
        );
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }
    public function test_create_skill_invalid_user_role_hr(): void
    {
        $user = User::factory()->create(
            [
                "role" => UserRolesEnums::HR()
            ]
        );
        $token = $this->login($user->email, 'password');
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->postJson(
            self::$API_PREFIX . "user/$user->id/skills"
        );
        $response->assertStatus(403);
    }
    public function test_create_skill_invalid_user_role_admin(): void
    {
        $user = User::factory()->create(
            [
                "role" => UserRolesEnums::ADMIN()
            ]
        );
        $token = $this->login($user->email, 'password');
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->postJson(
            self::$API_PREFIX . "user/$user->id/skills"
        );
        $response->assertStatus(403);
    }
}
