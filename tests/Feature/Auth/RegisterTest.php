<?php

namespace Tests\Feature\Auth;

use ERP\Models\User\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    public function test_guest_can_register_a_user(): void
    {
        $response = $this->postJson('/api/register', [
            'name' => 'New User',
            'email' => 'new-user@example.com',
            'password' => 'Senha_nada_segura123',
            'confirm_password' => 'Senha_nada_segura123',
        ]);

        $response->assertOk()
            ->assertJson([
                'message' => __('messages.do_it_first_access'),
            ]);

        $this->assertDatabaseHas('user', [
            'name' => 'New User',
            'email' => 'new-user@example.com',
            'verify_at' => null,
        ]);

        $this->assertTrue(Hash::check(
            'Senha_nada_segura123',
            User::where('email', 'new-user@example.com')->firstOrFail()->password,
        ));
    }

    public function test_registration_rejects_missing_and_mismatched_fields(): void
    {
        $this->postJson('/api/register', [
            'name' => 'New User',
            'email' => 'new-user@example.com',
            'password' => 'Senha_nada_segura123',
            'confirm_password' => 'Senha_diferente123',
        ])->assertUnprocessable()
            ->assertJsonValidationErrors(['confirm_password']);
    }
}
