<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ApiToken;

class AuthenticateApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('Authorization');

        if (!$token) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    
        $token = ApiToken::where('token', $token)->first();
    
        if (!$token || ($token->expires_at && $token->expires_at < now())) {
            return response()->json(['message' => 'Invalid token'], 401);
        }
    
        // Check permissions if needed
    
        return $next($request);
    }
}
