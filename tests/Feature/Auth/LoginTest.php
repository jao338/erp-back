<?php

namespace Tests\Feature\Auth;

use ERP\Models\User\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function test_verified_user_can_login(): void
    {
        $user = User::factory()->create([
            'email' => 'verified@example.com',
            'password' => 'Senha_nada_segura123',
        ]);
        $user->update(['verify_at' => now()]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'Senha_nada_segura123',
        ]);

        $response->assertOk()
            ->assertJsonStructure([
                'data' => ['email', 'nome', 'uuid', 'token'],
            ])
            ->assertJsonPath('data.email', $user->email);

        $this->assertNotEmpty($response->json('data.token'));
    }

    public function test_login_rejects_invalid_password(): void
    {
        $user = User::factory()->create([
            'email' => 'verified@example.com',
            'password' => 'Senha_nada_segura123',
        ]);
        $user->update(['verify_at' => now()]);

        $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'Senha_incorreta123',
        ])->assertStatus(422)
            ->assertJson([
                'status' => 'error',
                'message' => __('messages.invalid_login'),
            ]);
    }

    public function test_login_rejects_unverified_user(): void
    {
        $user = User::factory()->create([
            'email' => 'unverified@example.com',
            'password' => 'Senha_nada_segura123',
        ]);

        $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'Senha_nada_segura123',
        ])->assertStatus(422)
            ->assertJson([
                'status' => 'error',
                'message' => __('messages.without_access'),
            ]);
    }

    public function test_login_rejects_missing_required_fields(): void
    {
        $this->postJson('/api/login', [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['email', 'password']);
    }
}
