<?php

namespace Base\Base\Mail;

use Illuminate\Support\Facades\Mail;

final readonly class SendEmailService
{
    public function send(string|array $recipient, AbstractMail $mail): void {
        Mail::to($recipient)->queue($mail);
    }
}
