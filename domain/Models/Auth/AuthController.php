<?php

namespace Base\Models\Auth;

use App\Http\Controllers\Controller;
use Base\Base\Docs\Schemas\Auth\AuthLoginRequestSchema;
use Base\Base\Docs\Schemas\Auth\AuthLoginResponseSchema;
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
    path: '/login',
    summary: 'Autentica um usuário',
    tags: ['Autenticação'],
    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            ref: AuthLoginRequestSchema::class
        )
    ),
    responses: [
        new OA\Response(
            response: 200,
            description: 'Login realizado com sucesso',
            content: new OA\JsonContent(
                ref: AuthLoginResponseSchema::class
                )
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
