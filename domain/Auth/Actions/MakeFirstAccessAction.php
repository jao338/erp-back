<?php

namespace Base\Auth\Actions;

use Base\Base\Enums\OtpType;
use Base\Base\Exceptions\ERPException;
use Base\Base\Mail\FirstAccessMail;
use Base\Base\Mail\SendEmailService;
use Base\Models\OTPCodes\OTPCodes;
use Base\Models\User\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

final readonly class MakeFirstAccessAction {

    public function __construct(
        protected User $model,
        protected OTPCodes $otp,
        protected SendEmailService $sendEmailService,
    ) {}

    public function handle(array $data): void
    {
        $user = $this->model->where('email', $data['email'])->first();

        throw_if(
            $user && $user->verify_at,
            new ERPException(__('messages.user_verified'), 409),
        );

        $otp  = $user->otpCodes()->whereIsFirstAccess()->first();
        $plainCode = (string) random_int(10000, 99999);
        $expiresInMinutes = 15;
        $expiresAt = Carbon::now()->addMinutes($expiresInMinutes);

        if($otp){
            $otp->code       = Hash::make($plainCode);
            $otp->expires_at = $expiresAt;
            $otp->used_at    = NULL;
            $otp->attempts   = 0;
            $otp->save();
        } else {
            OTPCodes::create([
                'user_id'       => $user->id,
                'code'          => Hash::make($plainCode),
                'expires_at'    => $expiresAt,
                'used_at'       => NULL,
                'type'          => OtpType::FIRST_ACCESS,
                'attempts'      => 0,
            ]);
        }

        $this->sendEmailService->send(
            $user->email,
            mail: new FirstAccessMail(
                code:       $plainCode,
                name:       $user->name,
                expires_at: (string) $expiresInMinutes,
            ),
        );
    }
}
