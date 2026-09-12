<?php

namespace Base\Models\Auth\Actions;

use Base\Base\Exceptions\ERPException;
use Base\Base\Mail\FirstAccessMail;
use Base\Base\Mail\SendEmailService;
use Base\Models\OTPCodes\OTPCodes;
use Base\Models\User\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
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
        $otp = $user->otpCodes->whereIsFirstAccess()->first();

        if($otp){

            if($otp->attempts >= 5){
                // Bloquear o usuário, atualizar campo "bloqued"
                throw new ERPException(__('messages.too_many_attempts'));
            }

            $otp->increment('attempts');

            // Gerar com hash depois
            $otp->code->random_int(10000, 99999);
            $otp->expires_at = Carbon::now()->addMinutes(15);
            $otp->save();

            $this->sendEmailService->send(
                $user->email,
                mail: new FirstAccessMail(
                    user: $user,
                    code: $otp->code,
                ),
            );

            return;
        }

        OTPCodes::create([
            'user_id'       => $user->id,
            'code'          => random_int(10000, 99999), // Gerar com hash depois
            'expires_at'    => Carbon::now()->addMinutes(15),
            'used_at'       => NULL,
            'attempts'      => 0,
        ]);

    }
}
