<?php

namespace Base\Base\Mail;

use Base\Base\Mail\AbstractMail;
use Base\Models\User\User;

final class FirstAccessMail extends AbstractMail
{
    public function __construct(
        private readonly User $user,
        private readonly string $code,
        private readonly string $name,
        private readonly string $expires_at,
    ) {}

    protected function subject(): string
    {
        return 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.';
    }

    protected function view(): string
    {
        return 'emails.first-access';
    }

    protected function data(): array
    {
        return [
            'user'       => $this->user,
            'code'       => $this->code,
            'name'       => $this->name,
            'expires_at' => $this->expires_at,
        ];
    }
}
