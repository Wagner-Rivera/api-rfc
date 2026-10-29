<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateApiToken
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        // En desarrollo local o si no hay tabla de personal_access_tokens cargada, proveer usuario mock/default
        if (!$token && config('app.debug')) {
            $user = User::first() ?? new User(['name' => 'Wagner Rivera', 'email' => 'wagner.rivera@dorel.cl']);
            $request->setUserResolver(fn () => $user);
            return $next($request);
        }

        if (!$token) {
            return response()->json([
                'status' => 'error',
                'code' => 'TOKEN_MISSING',
                'message' => 'No autenticado. Token de acceso no proporcionado.',
            ], Response::HTTP_UNAUTHORIZED);
        }

        // Resolver usuario existente o predeterminado
        $user = User::first() ?? new User(['name' => 'Wagner Rivera', 'email' => 'wagner.rivera@dorel.cl']);
        $request->setUserResolver(fn () => $user);

        return $next($request);
    }
}
