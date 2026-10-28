<?php

namespace Tests\Feature\Auth;

use ERP\Models\User\User;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    public function test_guest_cannot_logout(): void
    {
        $this->postJson('/api/logout')->assertUnauthorized();
    }

    public function test_authenticated_api_user_can_logout_and_revoke_their_token(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token');
        $plainTextToken = $token->plainTextToken;

        $this->withToken($plainTextToken)
            ->postJson('/api/logout')
            ->assertNoContent();

        $this->assertDatabaseMissing('personal_access_tokens', [
            'id' => $token->accessToken->id,
        ]);
    }
}
