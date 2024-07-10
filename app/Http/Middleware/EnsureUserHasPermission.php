<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
class EnsureUserHasPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permissions): Response
    {
        $requiredPermissions = explode('|',$permissions);
        if(!$requiredPermissions)
        {
            $requiredPermissions = [];
        }
        $user = User::with('roles.permissions')->find(\Illuminate\Support\Facades\Auth::user()->user_id);

        if(!$user){
            return response()->json(['message' => 'Unauthenticated'],401);
        }
        $user = $this->extractPermissionsFromUser($user);

        $userPermissions = $user->permissions
            ->map(fn($permission) => $permission->name)
            ->values()
            ->all();
            if (!count(array_intersect($userPermissions, $requiredPermissions))) {
                return response()->json(
                    [
                        'message' => 'Permission not granted.',
                        'permissions' => $requiredPermissions,
                    ],
                    401
                );
            }
    
            $request->merge(['user' => $user]);
    
            return $next($request);
    }

    public function extractPermissionsFromUser(User $user): User
    {
        $permissions = collect();

        foreach ($user->roles as $role) {
            $permissions = $permissions->merge($role->permissions);
        }

        $permissions = $permissions
            ->flatten()
            ->unique('permission_id')
            ->values();

        $user->permissions = $permissions;

        return $user;
    }
}
