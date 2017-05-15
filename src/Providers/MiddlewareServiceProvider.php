<?php namespace Edutalk\Base\Users\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

use Edutalk\Base\Users\Http\Middleware\AuthenticateAdmin;
use Edutalk\Base\Users\Http\Middleware\GuestAdmin;

class MiddlewareServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * @var Router $router
         */
        $router = $this->app['router'];

        $router->aliasMiddleware('Edutalk.auth-admin', AuthenticateAdmin::class);
        $router->aliasMiddleware('Edutalk.guest-admin', GuestAdmin::class);
        $router->pushMiddlewareToGroup('web', AuthenticateAdmin::class);
    }
}
