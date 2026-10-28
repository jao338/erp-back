<?php

namespace Tests\Integration\Auth;

use ERP\Models\User\User;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    public function test_logout_deletes_the_current_sanctum_token(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('integration-token');

        $this->withToken($token->plainTextToken)
            ->postJson('/api/logout')
            ->assertNoContent();

        $this->assertDatabaseMissing('personal_access_tokens', [
            'id' => $token->accessToken->id,
        ]);
    }
}
