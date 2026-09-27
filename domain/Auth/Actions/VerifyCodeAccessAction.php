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

        $code = $this->otp
            ->where('user_id', $user->id)
            ->where('code', $data['code'])
            ->whereIsNotUsed()
            ->where('expires_at', '>', now())
            ->latest('expires_at')
            ->first();

        if(!$code){
            throw new ERPException('messages.code_not_found');
        }

        $user->update(['verify_at' => now()]);
        $code->update(['used_at' => now()]);
    }
}
