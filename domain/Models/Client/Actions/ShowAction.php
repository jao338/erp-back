<?php

namespace ERP\Models\Client\Actions;

use ERP\Exceptions\ERPException;
use ERP\Models\Client\Client;

final readonly class ShowAction {

    public function __construct(protected Client $model) {}

    public function handle(string $uuid): ?Client
    {
        $client = $this->model
            ->where('uuid', $uuid)
            ->first();

        throw_if(
            !$client,
            new ERPException(__('messages.not_found'), 404),
        );

        return $client;
    }
}
