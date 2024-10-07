<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserRole
{
    
    public function handle(Request $request, Closure $next, $role)
    {
        $user = auth()->user();


        if ($role === 'admin' && $user->type !== 'admin' && $user->type !== "superadmin") {
            return response()->json(['message' => 'Unauthorized'], 403);
        } elseif ($role === 'staff') {
            if ($user->type !== 'staff' && $user->type !== 'admin' && $user->type !== "superadmin" ) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
        }
        
        return $next($request);
    }
}
