<?php

namespace Base\Auth\Actions;

use Base\Base\Exceptions\ERPException;
use Base\Models\OTPCodes\OTPCodes;
use Base\Models\User\User;
use Illuminate\Support\Facades\Hash;

final readonly class VerifyCodeAccessAction {

    public function __construct(protected OTPCodes $otp, protected User $user) {}

    public function handle(array $data): void
    {
        $user = $this->user
            ->where('email', $data['email'])
            ->firstOrFail();

        $otp = $this->otp
            ->where('user_id', $user->id)
            ->whereIsFirstAccess()
            ->whereIsNotUsed()
            ->where('expires_at', '>', now())
            ->first();

        throw_if(
            !$otp,
            new ERPException(__('messages.code_not_found'), 409),
        );

        if ($otp->attempts >= 5) {
            $otp->increment('attempts');

            $user->update(['blocked' => TRUE]);

            throw new ERPException(
                __('messages.too_many_attempts'),
                409,
            );
        }

        if (!Hash::check((string) $data['code'], $otp->code)) {
            $otp->increment('attempts');

            throw new ERPException(
                __('messages.code_not_match'),
                409,
            );
        }

        $user->update(['verify_at' => now()]);
        $otp->update(['used_at'    => now()]);
    }
}
