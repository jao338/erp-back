<?php

namespace ERP\Auth\Actions;

use ERP\Models\User\User;

final readonly class RegisterAction {

    public function __construct(protected User $model) {}

    public function handle(array $data): void
    {
        $this->model->create($data);
    }
}
