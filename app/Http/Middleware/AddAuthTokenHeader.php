<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AddAuthTokenHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $cookie_name = env('AUTH_COOKIE_NAME');
        logger('Middleware executed');
        if (!$request->bearerToken() && $request->cookie($cookie_name)) {
            $token = $request->cookie($cookie_name);
            logger($token);
            $request->headers->add(['Authorization' => 'Bearer ' . $token]);
        } 
        $user = Auth::guard('api')->user();
        if ($user) {
            Auth::setUser($user);
        }
        return $next($request);
    }
}
