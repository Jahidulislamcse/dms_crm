<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): mixed
    {
        if (!Auth::check()) {
            return $request->expectsJson()
                ? response()->json(['error' => 'Unauthenticated'], 401)
                : redirect('/login');
        }

        $user = Auth::user();

        if (!$user->active) {
            Auth::logout();

            return $request->expectsJson()
                ? response()->json(['error' => 'Inactive account'], 403)
                : redirect('/login');
        }

        if (in_array('*', $roles) || in_array($user->role, $roles)) {
            return $next($request);
        }

        return $request->expectsJson()
            ? response()->json(['error' => 'Forbidden'], 403)
            : abort(403);
    }
}
