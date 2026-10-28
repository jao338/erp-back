<?php

namespace Tests\Integration\Auth;

use ERP\Models\User\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function test_login_persists_and_returns_a_sanctum_token_for_a_verified_user(): void
    {
        $user = User::factory()->create([
            'email' => 'integration-login@example.com',
            'password' => 'Senha_nada_segura123',
        ]);
        $user->update(['verify_at' => now()]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'Senha_nada_segura123',
        ]);

        $response->assertOk();
        $this->assertDatabaseCount('personal_access_tokens', 1);
        $this->assertNotEmpty($response->json('data.token'));
    }
}
