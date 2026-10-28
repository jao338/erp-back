<?php

namespace Tests\Integration\Auth;

use ERP\Models\User\User;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    public function test_register_action_persists_a_user_without_verifying_access(): void
    {
        $this->postJson('/api/register', [
            'name' => 'Integration User',
            'email' => 'integration-register@example.com',
            'password' => 'Senha_nada_segura123',
            'confirm_password' => 'Senha_nada_segura123',
        ])->assertOk();

        $user = User::where('email', 'integration-register@example.com')->firstOrFail();

        $this->assertSame('Integration User', $user->name);
        $this->assertNull($user->verify_at);
    }
}
