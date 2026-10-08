<?php

namespace Base\Auth\Actions;

use Base\Models\User\User;

final readonly class RegisterAction {

    public function __construct(protected User $model) {}

    public function handle(array $data): void
    {
        $this->model->create($data);
    }
}
