<?php

namespace Tests\Integration\Auth;

use ERP\Models\User\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthenticatedUserTest extends TestCase
{
    public function test_me_route_returns_the_user_from_the_sanctum_guard(): void
    {
        $user = User::factory()->create([
            'email' => 'integration-me@example.com',
            'name' => 'Integration User',
        ]);
        Sanctum::actingAs($user);

        $this->getJson('/api/me')
            ->assertOk()
            ->assertJsonPath('data.email', 'integration-me@example.com')
            ->assertJsonPath('data.nome', 'Integration User');
    }
}
