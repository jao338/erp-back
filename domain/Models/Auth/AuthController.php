<?php

namespace Base\Models\Auth;

use App\Http\Controllers\Controller;
use Base\Models\Auth\Actions\LoginAction;
use Base\Models\Auth\Actions\LogoutAction;
use Base\Models\Auth\Actions\RegisterAction;
use Base\Models\Auth\Requests\AuthLoginRequest;
use Base\Models\Auth\Requests\AuthRegisterRequest;
use Base\Models\Auth\Resources\LoginResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

class AuthController extends Controller {

    #[OA\Post(
    path: '/api/login',
    summary: 'Realiza login',
    tags: ['Auth'],
    responses: [
            new OA\Response(
                response: 200,
                description: 'OK'
            )
        ]
    )]
    public function login(AuthLoginRequest $request, LoginAction $action): JsonResource
    {
        $user = $action->handle($request->validated());

        return new LoginResource($user);
    }

    public function register(AuthRegisterRequest $request, RegisterAction $action): JsonResource
    {
        $user = $action->handle($request->validated());

        return new LoginResource($user);
    }

    public function logout(Request $request, LogoutAction $action): JsonResponse
    {
        $action->handle($request);

        return response()->json(['message' => __('messages.success_logout')]);
    }

    public function me(): JsonResource
    {
        $user = auth()->user();

        return new LoginResource($user);
    }
}
