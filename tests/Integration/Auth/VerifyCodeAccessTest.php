<?php

namespace Tests\Integration\Auth;

use ERP\Enums\OtpType;
use ERP\Models\OTPCodes\OTPCodes;
use ERP\Models\User\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class VerifyCodeAccessTest extends TestCase
{
    public function test_verify_code_updates_the_user_and_consumes_the_otp_atomically(): void
    {
        $user = User::factory()->create([
            'email' => 'integration-verify@example.com',
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
        ])->assertOk();

        $this->assertNotNull($user->fresh()->verify_at);
        $this->assertNotNull($otp->fresh()->used_at);
    }
}
