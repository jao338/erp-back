<?php

namespace Tests\Feature\Auth;

use ERP\Enums\OtpType;
use ERP\Mail\FirstAccessMail;
use ERP\Models\User\User;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class FirstAccessTest extends TestCase
{
    public function test_user_can_request_a_first_access_code(): void
    {
        Mail::fake();

        $user = User::factory()->create([
            'email' => 'first-access@example.com',
        ]);

        $response = $this->postJson('/api/first-access', [
            'email' => $user->email,
        ]);

        $response->assertOk()
            ->assertJson([
                'message' => __('messages.code_sent_via_email'),
            ]);

        $this->assertDatabaseHas('otp_codes', [
            'user_id' => $user->id,
            'type' => OtpType::FIRST_ACCESS->value,
            'used_at' => null,
        ]);

        Mail::assertQueued(FirstAccessMail::class);
    }

    public function test_first_access_rejects_a_verified_user(): void
    {
        $user = User::factory()->create([
            'email' => 'verified@example.com',
        ]);
        $user->update(['verify_at' => now()]);

        $this->postJson('/api/first-access', [
            'email' => $user->email,
        ])->assertStatus(409)
            ->assertJson([
                'status' => 'error',
                'message' => __('messages.user_verified'),
            ]);
    }

    public function test_first_access_rejects_an_unknown_email(): void
    {
        $this->postJson('/api/first-access', [
            'email' => 'unknown@example.com',
        ])->assertUnprocessable()
            ->assertJsonValidationErrors(['email']);
    }
}
