<?php

namespace Base\Models\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource {

    public function toArray($request): array
    {
        return [
            'email'            => $this->email,
            'nome'             => $this->name,
            'uuid'             => $this->uuid,
            'token'            => $this->getActiveToken(),
        ];
    }
}
