<?php

namespace Base\Models\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource {

    public function toArray($request): array
    {
        return [
            'email'            => $this->email,
            'nome'             => $this->name,
            'token'            => $this->getActiveToken(),
        ];
    }
}
