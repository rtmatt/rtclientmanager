<?php
namespace RTMatt\MonthlyService\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
class MonthlyServiceServiceProvider extends ServiceProvider{

    public function register()
    {
        $this->app->bind('\RTMatt\MonthlyService\Contracts\RTGuardContract', function ($app) {
            $temp = config('rtclientmanager.guard');
            return new $temp;
        });

        $path = __DIR__ . '/../../resources/views';
        $this->loadViewsFrom($path,'rtclientmanager');

        $this->mergeConfigFrom(__DIR__ . '/../../config/rtclientmanager.php', 'rtclientmanager');


    }


    /**
     * This relies on the app RouteServiceProvider to boot first.
     * @param Router $router
     */
    public function boot(Router $router)
    {
        //parent::boot($router);

        $router->model('service_plan', 'RTMatt\MonthlyService\ServicePlan');
        $this->publishes([
            __DIR__.'/../../dist/' => public_path('vendor/rtclientmanager'),
        ], 'public');

        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations')
        ], 'migrations');
        if (! $this->app->routesAreCached()) {

            require __DIR__.'/../routes/routes.php';
        }

        $this->publishes([$this->configPath() => config_path('rtclientmanager.php')]);

    }
}