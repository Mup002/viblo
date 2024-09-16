<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
class CheckTokenExpiration
{
    public function handle(Request $request, Closure $next)
    {
        logger("check token : start");
        $token = $request->bearerToken();
        if($token)
        {
            $accessToken = PersonalAccessToken::findToken($token);
            if($accessToken && $accessToken->expires_at && $accessToken->expires_at->isPast())
            {
                return response()->json(['message'=>'token has expired'],401);
            }
        }
        logger("check token : done");
        return $next($request);
    }
    
}