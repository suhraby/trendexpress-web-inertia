<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserProfileIsComplete
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return $next($request);
        }

        if ($user->needsProfileCompletion()) {
            if (! $request->routeIs([
                'profile.complete',
                'profile.complete.update',
                'logout',
            ])) {
                return redirect()->route('profile.complete');
            }
        }

        return $next($request);
    }
}
