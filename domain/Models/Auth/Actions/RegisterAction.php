<?php

namespace Base\Models\Auth\Actions;

use Base\Models\User\User;
use Illuminate\Support\Facades\Auth;

final readonly class RegisterAction {

    public function __construct(protected User $model) {}

    public function handle(array $data): void
    {
        $this->model->create($data);
    }
}
