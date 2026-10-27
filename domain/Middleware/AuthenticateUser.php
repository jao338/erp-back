<?php

namespace ERP\Middleware;

use ERP\Models\User\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateUser {

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ( $user && ! ($user instanceof User)) {
            return response()->json([
                'message' => Lang::get('messages.unauthorized')
            ], 403);
        }

        return $next($request);
    }
}
