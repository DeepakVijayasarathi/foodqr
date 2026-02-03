<?php

namespace App\Http\Middleware;

use Closure;

class Installed
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Installer enforcement disabled: allow requests through
        // Previously this redirected to /install when storage/installed
        // was missing. Returning the next middleware/request handler
        // prevents forced redirects to the installer route.
        return $next($request);
    }
}