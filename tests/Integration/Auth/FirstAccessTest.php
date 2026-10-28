<?php

namespace Tests\Integration\Auth;

use ERP\Enums\OtpType;
use ERP\Mail\FirstAccessMail;
use ERP\Models\OTPCodes\OTPCodes;
use ERP\Models\User\User;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class FirstAccessTest extends TestCase
{
    public function test_first_access_creates_an_otp_and_queues_the_email(): void
    {
        Mail::fake();
        $user = User::factory()->create([
            'email' => 'integration-first-access@example.com',
        ]);

        $this->postJson('/api/first-access', [
            'email' => $user->email,
        ])->assertOk();

        $otp = OTPCodes::where('user_id', $user->id)->firstOrFail();

        $this->assertSame(OtpType::FIRST_ACCESS->value, $otp->type);
        $this->assertNull($otp->used_at);
        $this->assertGreaterThan(now(), $otp->expires_at);
        Mail::assertQueued(FirstAccessMail::class);
    }
}
