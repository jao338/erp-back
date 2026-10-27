<?php

namespace ERP\Auth\Actions;

use ERP\Enums\OtpType;
use ERP\Exceptions\ERPException;
use ERP\Mail\FirstAccessMail;
use ERP\Mail\SendEmailService;
use ERP\Models\OTPCodes\OTPCodes;
use ERP\Models\User\User;
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
