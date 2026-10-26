<?php

namespace Base\Auth;

use App\Http\Controllers\Controller;
use Base\Auth\Actions\LoginAction;
use Base\Auth\Actions\LogoutAction;
use Base\Auth\Actions\MakeFirstAccessAction;
use Base\Auth\Actions\RegisterAction;
use Base\Auth\Actions\VerifyCodeAccessAction;
use Base\Auth\Requests\AuthFirstAccessRequest;
use Base\Auth\Requests\AuthLoginRequest;
use Base\Auth\Requests\AuthRegisterRequest;
use Base\Auth\Requests\AuthVerifyCodeAccessRequest;
use Base\Base\Docs\Schemas\Auth\AuthFirstAccessRequestSchema;
use Base\Base\Docs\Schemas\Auth\AuthLoginRequestSchema;
use Base\Base\Docs\Schemas\Auth\AuthLoginResponseSchema;
use Base\Base\Docs\Schemas\Auth\AuthMessageResponseSchema;
use Base\Base\Docs\Schemas\Auth\AuthRegisterRequestSchema;
use Base\Base\Docs\Schemas\Auth\AuthVerifyCodeAccessRequestSchema;
use Base\Base\Docs\Schemas\Errors\ERPErrorResponseSchema;
use Base\Base\Docs\Schemas\Errors\UnauthorizedResponseSchema;
use Base\Base\Docs\Schemas\Errors\ValidationErrorResponseSchema;
use Base\Models\User\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use OpenApi\Attributes as OA;

class AuthController extends Controller {

    #[OA\Post(
        path: '/api/login',
        summary: 'Autentica um usuário',
        tags: ['Autenticação'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: AuthLoginRequestSchema::class)
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Login realizado com sucesso',
                content: new OA\JsonContent(ref: AuthLoginResponseSchema::class)
            ),
            new OA\Response(
                response: 422,
                description: 'Erro de validação ou falha nas credenciais/acesso',
                content: new OA\JsonContent(
                    oneOf: [
                        new OA\Schema(ref: ValidationErrorResponseSchema::class),
                        new OA\Schema(ref: ERPErrorResponseSchema::class),
                    ]
                )
            )
        ]
    )]
    public function login(AuthLoginRequest $request, LoginAction $action): JsonResource
    {
        $user = $action->handle($request->validated());

        return new UserResource($user);
    }

    #[OA\Post(
        path: '/api/register',
        summary: 'Registra um novo usuário',
        tags: ['Autenticação'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: AuthRegisterRequestSchema::class)
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Usuário registrado; o primeiro acesso deve ser solicitado separadamente',
                content: new OA\JsonContent(ref: AuthMessageResponseSchema::class)
            ),
            new OA\Response(
                response: 422,
                description: 'Erro de validação',
                content: new OA\JsonContent(ref: ValidationErrorResponseSchema::class)
            )
        ]
    )]
    public function register(AuthRegisterRequest $request, RegisterAction $action): JsonResponse
    {
        $action->handle($request->validated());

        return response()->json(['message' => __('messages.do_it_first_access')]);
    }

    #[OA\Post(
        path: '/api/logout',
        summary: 'Encerra a sessão do usuário autenticado',
        tags: ['Autenticação'],
        security: [['sanctum' => []]],
        responses: [
            new OA\Response(
                response: 204,
                description: ''
            ),
            new OA\Response(
                response: 401,
                description: 'Usuário não autenticado',
                content: new OA\JsonContent(ref: UnauthorizedResponseSchema::class)
            )
        ]
    )]
    public function logout(Request $request, LogoutAction $action): Response
    {
        $action->handle($request);

        return response()->noContent();
    }

    #[OA\Post(
        path: '/api/first-access',
        summary: 'Solicita o código para o primeiro acesso',
        tags: ['Autenticação'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: AuthFirstAccessRequestSchema::class)
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Código enviado por e-mail',
                content: new OA\JsonContent(ref: AuthMessageResponseSchema::class)
            ),
            new OA\Response(
                response: 409,
                description: 'Usuário já verificado',
                content: new OA\JsonContent(ref: ERPErrorResponseSchema::class)
            ),
            new OA\Response(
                response: 422,
                description: 'Erro de validação',
                content: new OA\JsonContent(ref: ValidationErrorResponseSchema::class)
            )
        ]
    )]
    public function firstAccess(
        AuthFirstAccessRequest $request,
        MakeFirstAccessAction $action,
    ): JsonResponse {
        $action->handle($request->validated());

        return response()->json([
            'message' => __('messages.code_sent_via_email'),
        ]);
    }

    #[OA\Post(
        path: '/api/verify-code-access',
        summary: 'Valida o código do primeiro acesso',
        tags: ['Autenticação'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: AuthVerifyCodeAccessRequestSchema::class)
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Usuário verificado com sucesso',
                content: new OA\JsonContent(ref: AuthMessageResponseSchema::class)
            ),
            new OA\Response(
                response: 409,
                description: 'Código inválido, expirado ou com excesso de tentativas',
                content: new OA\JsonContent(ref: ERPErrorResponseSchema::class)
            ),
            new OA\Response(
                response: 422,
                description: 'Erro de validação',
                content: new OA\JsonContent(ref: ValidationErrorResponseSchema::class)
            )
        ]
    )]
    public function verifyCodeAccess(AuthVerifyCodeAccessRequest $request, VerifyCodeAccessAction $action): JsonResponse
    {
        $action->handle($request->validated());

        return response()->json(['message' => __('messages.user_verified')]);
    }

    #[OA\Get(
        path: '/api/me',
        summary: 'Retorna o usuário autenticado',
        tags: ['Autenticação'],
        security: [['sanctum' => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Usuário autenticado retornado com sucesso',
                content: new OA\JsonContent(ref: AuthLoginResponseSchema::class)
            ),
            new OA\Response(
                response: 401,
                description: 'Usuário não autenticado',
                content: new OA\JsonContent(ref: UnauthorizedResponseSchema::class)
            )
        ]
    )]
    public function me(): JsonResource
    {
        $user = auth()->user();

        return new UserResource($user);
    }
}
