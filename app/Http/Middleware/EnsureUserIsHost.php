<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Restricts a route to users with role = 'host'.
 *
 * Intended to be stacked AFTER 'auth', which already redirects guests.
 * The guest branch below is defence in depth in case it is ever used
 * alone.
 *
 * IMPORTANT: an authenticated admin is redirected to the admin
 * dashboard, NOT to the login page. The login route sits behind the
 * 'guest' middleware, so bouncing a logged-in user there would be
 * caught by RedirectIfAuthenticated and ping-pong the request.
 */
class EnsureUserIsHost
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login')
                ->with('error', 'Please sign in to continue.');
        }

        if (! $user->isHost()) {
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }

            abort(403, 'This area is for hosts only.');
        }

        return $next($request);
    }
}
