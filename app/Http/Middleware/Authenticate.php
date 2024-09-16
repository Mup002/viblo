<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }

    public function handle($request, Closure $next, ...$guards)
    {
        $cookie_name = env('AUTH_COOKIE_NAME');
        logger('Middleware executed');
        if (!$request->bearerToken()) {
            if ($request->hasCookie($cookie_name)) {
                $token = $request->cookie($cookie_name);
                logger($token);
                $request->headers->add(['Authorization' => 'Bearer ' . $token]);
                
            }
            logger('fail');
        }
        $this->authenticate($request, $guards);

        return $next($request);
    }
}
