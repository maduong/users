<?php namespace Edutalk\Base\Users\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Edutalk\Base\Users\Http\Middleware\BootstrapModuleMiddleware;

class ModuleProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        /*Load views*/
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'edutalk-users');
        /*Load translations*/
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'edutalk-users');
        /*Load migrations*/
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        $this->publishes([
            __DIR__ . '/../../resources/views' => config('view.paths')[0] . '/vendor/edutalk-users',
        ], 'views');
        $this->publishes([
            __DIR__ . '/../../resources/lang' => base_path('resources/lang/vendor/edutalk-users'),
        ], 'lang');
        $this->publishes([
            __DIR__ . '/../../config' => base_path('config'),
        ], 'config');
        $this->publishes([
            __DIR__ . '/../../resources/assets' => resource_path('assets'),
        ], 'edutalk-assets');
        $this->publishes([
            __DIR__ . '/../../resources/public' => public_path(),
        ], 'Edutalk-public-assets');

        app()->booted(function () {
            $this->app->register(BootstrapModuleServiceProvider::class);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        load_module_helpers(__DIR__);

        config([
            'auth.defaults' => [
                'guard' => 'web-admin',
                'passwords' => 'admin-users',
            ],
            'auth.guards.web-admin' => [
                'driver' => 'session',
                'provider' => 'admin-users',
            ],
            'auth.providers.admin-users' => [
                'driver' => 'eloquent',
                'model' => \Edutalk\Base\Users\Models\User::class,
            ],
            'auth.passwords.admin-users' => [
                'provider' => 'admin-users',
                'table' => 'password_resets',
                'expire' => 60,
            ],
        ]);

        $this->app->register(RouteServiceProvider::class);
        $this->app->register(MiddlewareServiceProvider::class);
        $this->app->register(RepositoryServiceProvider::class);
        $this->app->register(HookServiceProvider::class);
        $this->app->register(EventServiceProvider::class);

        /**
         * @var Router $router
         */
        $router = $this->app['router'];
        $router->pushMiddlewareToGroup('web', BootstrapModuleMiddleware::class);
    }
}
