<?php namespace Edutalk\Base\Users\Http\Middleware;

use \Closure;

class BootstrapModuleMiddleware
{
    public function __construct()
    {

    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  array|string $params
     * @return mixed
     */
    public function handle($request, Closure $next, ...$params)
    {
        /**
         * Register to dashboard menu
         */
        dashboard_menu()->registerItem([
            'id' => 'edutalk-users',
            'priority' => 3,
            'parent_id' => null,
            'heading' => trans('edutalk-users::base.admin_menu.heading'),
            'title' => trans('edutalk-users::base.admin_menu.title'),
            'font_icon' => 'icon-users',
            'link' => route('admin::users.index.get'),
            'css_class' => null,
            'permissions' => ['view-users'],
        ]);

        admin_quick_link()->register('user', [
            'title' => trans('edutalk-users::base.user'),
            'url' => route('admin::users.create.get'),
            'icon' => 'icon-users',
        ]);

        return $next($request);
    }
}
