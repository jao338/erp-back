<?php

namespace ERP\Mail;

use ERP\Mail\AbstractMail;
use ERP\Models\User\User;
use Illuminate\Support\Facades\Lang;

final class FirstAccessMail extends AbstractMail
{
    public function __construct(
        private readonly string $code,
        private readonly string $name,
        private readonly string $expires_at,
    ) {}

    protected function getSubject(): string
    {
        return Lang::get('messages.emails.first-access.subject', ['code' => $this->code]);
    }

    protected function getView(): string
    {
        return 'emails.first_access';
    }

    protected function getData(): array
    {
        return [
            'code'       => $this->code,
            'name'       => $this->name,
            'expires_at' => $this->expires_at,
        ];
    }
}
