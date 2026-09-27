<?php

namespace Base\Auth;

use App\Http\Controllers\Controller;
use Base\Auth\Actions\LoginAction;
use Base\Auth\Actions\LogoutAction;
use Base\Auth\Actions\MakeFirstAccessAction;
use Base\Auth\Actions\RegisterAction;
use Base\Auth\Requests\AuthLoginRequest;
use Base\Auth\Requests\AuthRegisterRequest;
use Base\Auth\Resources\LoginResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class AuthController extends Controller {

    public function login(AuthLoginRequest $request, LoginAction $action): JsonResource
    {
        $user = $action->handle($request->validated());

        return new LoginResource($user);
    }

    public function register(AuthRegisterRequest $request, RegisterAction $action): JsonResponse
    {
        $action->handle($request->validated());

        return response()->json(['message' => __('messages.do_it_first_access')]);
    }

    public function logout(Request $request, LogoutAction $action): Response
    {
        $action->handle($request);

        return response()->noContent();
    }

    public function firstAccess(AuthRegisterRequest $request, MakeFirstAccessAction $action): JsonResponse
    {
        $action->handle($request->validated());

        return response()->json(['message' => __('messages.code_sent_via_email')]);
    }

    public function me(): JsonResource
    {
        $user = auth()->user();

        return new LoginResource($user);
    }
}
