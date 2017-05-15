<?php namespace Edutalk\Base\Users\Http\Middleware;

use \Closure;

class GuestAdmin
{
    /**
     * Handle an incoming request.
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth('web-admin')->check()) {
            return redirect()->to(route('admin::dashboard.index.get'));
        }

        return $next($request);
    }
}
