<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Restricts a route to users with role = 'admin'.
 *
 * Intended to be stacked AFTER 'auth'. A signed-in host hitting an admin
 * route gets a hard 403 rather than a redirect - there is no useful
 * place to send them, and a redirect would hide the authorisation
 * failure.
 */
class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login')
                ->with('error', 'Please sign in to continue.');
        }

        if (! $user->isAdmin()) {
            abort(403, 'Administrator access required.');
        }

        return $next($request);
    }
}
