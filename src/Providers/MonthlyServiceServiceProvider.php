<?php
namespace RTMatt\MonthlyService\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
class MonthlyServiceServiceProvider extends ServiceProvider{

    public function register()
    {
        $this->app->bind('\RTMatt\MonthlyService\Contracts\RTGuardContract', function ($app) {
            $temp = config('monthlyserice.guard');
            return new $temp;
        });

        $path = __DIR__ . '/../../resources/views';
        $this->loadViewsFrom($path,'rtdashboard');




    }


    /**
     * This relies on the app RouteServiceProvider to boot first.
     * @param Router $router
     */
    public function boot(Router $router)
    {
        //parent::boot($router);

        $router->model('service_plan', 'RTMatt\MonthlyService\ServicePlan');
    }
}