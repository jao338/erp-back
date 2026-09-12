<?php

namespace Base\Models\Auth;

use App\Http\Controllers\Controller;
use Base\Base\Docs\Schemas\Auth\AuthLoginRequestSchema;
use Base\Base\Docs\Schemas\Auth\AuthLoginResponseSchema;
use Base\Base\Docs\Schemas\Auth\AuthRegisterRequestSchema;
use Base\Base\Docs\Schemas\Auth\LogoutResponseSchema;
use Base\Base\Docs\Schemas\Errors\UnauthorizedResponseSchema;
use Base\Base\Docs\Schemas\Errors\ValidationErrorResponseSchema;
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
            ),

        new OA\Response(
            response: 422,
            description: 'Erro de validação',
            content: new OA\JsonContent(
                ref: ValidationErrorResponseSchema::class
            )
        )
        ]
    )]
    public function login(AuthLoginRequest $request, LoginAction $action): JsonResource
    {
        $user = $action->handle($request->validated());

        return new LoginResource($user);
    }

    #[OA\Post(
        path: '/register',
        summary: 'Registra um novo usuário',
        tags: ['Autenticação'],

        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                ref: AuthRegisterRequestSchema::class
            )
        ),

        responses: [
            new OA\Response(
                response: 201,
                description: 'Usuário registrado e autenticado com sucesso',
                content: new OA\JsonContent(
                    ref: AuthLoginResponseSchema::class
                )
            ),

            new OA\Response(
                response: 422,
                description: 'Erro de validação',
                content: new OA\JsonContent(
                    ref: ValidationErrorResponseSchema::class
                )
            )
        ]
    )]
    public function register(AuthRegisterRequest $request, RegisterAction $action): JsonResource
    {
        $user = $action->handle($request->validated());

        return new LoginResource($user);
    }

    #[OA\Post(
        path: '/logout',
        summary: 'Encerra a sessão ou revoga o token do usuário autenticado',
        tags: ['Autenticação'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Logout realizado com sucesso',
                content: new OA\JsonContent(
                    ref: LogoutResponseSchema::class
                )
            )
        ]
    )]
    public function logout(Request $request, LogoutAction $action): JsonResponse
    {
        $action->handle($request);

        return response()->json(['message' => __('messages.success_logout')]);
    }

    #[OA\Get(
        path: '/me',
        summary: 'Retorna o usuário autenticado',
        tags: ['Autenticação'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Usuário autenticado retornado com sucesso',
                content: new OA\JsonContent(
                    ref: AuthLoginResponseSchema::class
                )
            ),

            new OA\Response(
                response: 401,
                description: 'Usuário não autenticado',
                content: new OA\JsonContent(
                    ref: UnauthorizedResponseSchema::class
                )
            )
        ]
    )]
    public function me(): JsonResource
    {
        $user = auth()->user();

        return new LoginResource($user);
    }
}
