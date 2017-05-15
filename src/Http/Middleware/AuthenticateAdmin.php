<?php namespace Edutalk\Base\Users\Http\Middleware;

use \Closure;

class AuthenticateAdmin
{
    const LOGIN_ROUTE_NAME_GET = 'admin::auth.login.get';

    const LOGIN_ROUTE_NAME_POST = 'admin::auth.login.post';

    const DASHBOARD_CHANGE_LANGUAGE = 'admin::dashboard-language.get';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $currentRouteName = $request->route()->getName();

        if ($currentRouteName === $this::LOGIN_ROUTE_NAME_GET || $currentRouteName === $this::LOGIN_ROUTE_NAME_POST || $currentRouteName === $this::DASHBOARD_CHANGE_LANGUAGE) {
            return $next($request);
        }

        if (is_admin_panel()) {
            if (auth('web-admin')->guest()) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response('Unauthorized.', \Constants::UNAUTHORIZED_CODE);
                }
                return redirect()->guest(route($this::LOGIN_ROUTE_NAME_GET));
            }
        }

        return $next($request);
    }
}
