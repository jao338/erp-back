<?php

namespace Tests\Feature\Auth;

use ERP\Models\User\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthenticatedUserTest extends TestCase
{
    public function test_guest_cannot_view_the_authenticated_user(): void
    {
        $this->getJson('/api/me')->assertUnauthorized();
    }

    public function test_authenticated_user_can_view_their_profile(): void
    {
        $user = User::factory()->create([
            'email' => 'me@example.com',
            'name' => 'Authenticated User',
        ]);

        Sanctum::actingAs($user);

        $this->getJson('/api/me')
            ->assertOk()
            ->assertJsonStructure([
                'data' => ['email', 'nome', 'uuid', 'token'],
            ])
            ->assertJsonPath('data.email', $user->email)
            ->assertJsonPath('data.nome', $user->name);
    }
}
