<?php

namespace Base\Auth\Actions;

use Base\Base\Exceptions\ERPException;
use Base\Models\OTPCodes\OTPCodes;
use Base\Models\User\User;

final readonly class VerifyCodeAccessAction {

    public function __construct(protected OTPCodes $otp, protected User $user) {}

    public function handle(array $data): void
    {
        $user = $this->user
            ->where('email', $data['email'])
            ->firstOrFail();

        $otp = $this->otp
            ->where('user_id', $user->id)
            ->whereIsNotUsed()
            ->where('expires_at', '>', now())
            ->latest('expires_at')
            ->first();

        if(!$otp){
            throw new ERPException('messages.code_not_found');
        }

        if($otp->attempts >= 5){
            throw new ERPException('messages.too_many_attempts');
        }

        if((string) $otp->code !== (string) $data['code']){
            $otp->increment('attempts');

            if($otp->attempts >= 5){
                throw new ERPException('messages.too_many_attempts');
            }

            throw new ERPException('messages.code_not_found');
        }

        $user->update(['verify_at' => now()]);
        $otp->update(['used_at'   => now()]);
    }
}
