<?php

namespace Tests\Feature\Auth;

use ERP\Enums\OtpType;
use ERP\Models\OTPCodes\OTPCodes;
use ERP\Models\User\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class VerifyCodeAccessTest extends TestCase
{
    public function test_valid_first_access_code_verifies_the_user(): void
    {
        $user = User::factory()->create([
            'email' => 'verify@example.com',
        ]);
        $otp = OTPCodes::create([
            'user_id' => $user->id,
            'code' => Hash::make('12345'),
            'type' => OtpType::FIRST_ACCESS,
            'expires_at' => now()->addMinutes(15),
            'attempts' => 0,
        ]);

        $this->postJson('/api/verify-code-access', [
            'email' => $user->email,
            'code' => 12345,
        ])->assertOk()
            ->assertJson([
                'message' => __('messages.user_verified'),
            ]);

        $this->assertNotNull($user->fresh()->verify_at);
        $this->assertNotNull($otp->fresh()->used_at);
    }

    public function test_invalid_first_access_code_increments_attempts(): void
    {
        $user = User::factory()->create([
            'email' => 'verify@example.com',
        ]);
        $otp = OTPCodes::create([
            'user_id' => $user->id,
            'code' => Hash::make('12345'),
            'type' => OtpType::FIRST_ACCESS,
            'expires_at' => now()->addMinutes(15),
            'attempts' => 0,
        ]);

        $this->postJson('/api/verify-code-access', [
            'email' => $user->email,
            'code' => 54321,
        ])->assertStatus(409)
            ->assertJson([
                'status' => 'error',
                'message' => __('messages.code_not_match'),
            ]);

        $this->assertSame(1, $otp->fresh()->attempts);
        $this->assertNull($user->fresh()->verify_at);
    }

    public function test_verify_code_rejects_an_invalid_payload(): void
    {
        $this->postJson('/api/verify-code-access', [
            'email' => 'not-an-email',
            'code' => 1,
        ])->assertUnprocessable()
            ->assertJsonValidationErrors(['email', 'code']);
    }
}
