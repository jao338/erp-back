<?php

namespace Base\Models\Auth\Actions;

use Base\Base\Exceptions\ERPException;
use Base\Models\User\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

final readonly class LoginAction {

    public function __construct(protected User $model) {}

    public function handle(array $data): User
    {
        $email    = $data['email'];
        $password = $data['password'];

        $user = User::where('email', $email)->first();

        throw_if(!$user || !Hash::check($password, $user->password), new ERPException(__('messages.invalid_login')));

        Auth::login($user);

        $this->setToken($user);

        return $user;
    }

    private function setToken(User $user): void
    {
        if ( ! requestFromFrontend()) {
            $token = $user->createToken('token-api')->plainTextToken;

            $user->setActiveToken($token);
        }
    }
}
