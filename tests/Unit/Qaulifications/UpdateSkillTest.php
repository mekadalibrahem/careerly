<?php

namespace Tests\Unit\Qaulifications;

use App\Models\User;
use App\Modules\Qualifications\Entities\Models\Skill;
use App\Modules\Users\Enums\UserRolesEnums;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateSkillTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_skill_valid(): void
    {
        $user = User::factory()->create();
        $token = $this->login($user->email, 'password');
        $skill = Skill::create([
            "name" => "name",
            "user_id" => $user->id
        ]);
        $this->assertDatabaseHas('skills', [
            "user_id" => $user->id,
            "name" => $skill->name
        ]);
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->putJson(
            self::$API_PREFIX . "user/$user->id/skills/$skill->id",
            [
                'name' => "new-name",
            ]
        );
        $response->assertStatus(200);
        $this->assertDatabaseHas('skills', [
            "user_id" => $user->id,
            "name" => "new-name",
        ]);
    }
    public function test_update_skill_unauthenticated(): void
    {
        $user = User::factory()->create();
        $skill = Skill::create([
            "name" => "name",
            "user_id" => $user->id
        ]);
        $this->assertDatabaseHas('skills', [
            "user_id" => $user->id,
            "name" => $skill->name
        ]);
        $response = $this->putJson(
            self::$API_PREFIX . "user/$user->id/skills/$skill->id",
            [
                'name' => "name-new",
            ]
        );

        $response->assertStatus(401);
    }
    public function test_update_skill_invalid_name_required(): void
    {
        $user = User::factory()->create();
        $token = $this->login($user->email, 'password');
        $skill = Skill::create([
            "name" => "name",
            "user_id" => $user->id
        ]);
        $this->assertDatabaseHas('skills', [
            "user_id" => $user->id,
            "name" => $skill->name
        ]);
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->putJson(
            self::$API_PREFIX . "user/$user->id/skills/$skill->id"
        );
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }
    
   
}
