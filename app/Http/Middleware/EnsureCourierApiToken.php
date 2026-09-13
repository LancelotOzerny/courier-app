<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCourierApiToken
{
    public function handle(Request $request, Closure $next): Response|JsonResponse
    {
        $configuredToken = config('courier.orders_api_token');
        $providedToken = $request->header('X-API-Token');

        if (! is_string($configuredToken) || $configuredToken === '' || ! is_string($providedToken) || ! hash_equals($configuredToken, $providedToken)) {
            return response()->json(['message' => 'Unauthenticated.'], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
