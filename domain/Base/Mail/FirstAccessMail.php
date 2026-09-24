<?php

namespace Base\Base\Mail;

use Base\Base\Mail\AbstractMail;
use Base\Models\User\User;
use Illuminate\Support\Facades\Lang;

final class FirstAccessMail extends AbstractMail
{
    public function __construct(
        private readonly string $code,
        private readonly string $name,
        private readonly string $expires_at,
    ) {}

    protected function subject(): string
    {
        return Lang::get('messages.emails.first-access.subject', ['code' => $this->code]);
    }

    protected function view(): string
    {
        return 'emails.first_access';
    }

    protected function data(): array
    {
        return [
            'code'       => $this->code,
            'name'       => $this->name,
            'expires_at' => $this->expires_at,
        ];
    }
}
