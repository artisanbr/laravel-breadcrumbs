<?php

namespace ArtisanLabs\Breadcrumbs;

use ArtisanLabs\Breadcrumbs\Providers\Generator;
use ArtisanLabs\Breadcrumbs\Providers\Manager;
use ArtisanLabs\Breadcrumbs\Components\BreadcrumbsRender;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class LaravelBreadcrumbsServiceProvider extends ServiceProvider
{

    private $resources_path = __DIR__ . "/resources/";
    private $views_path = __DIR__ . "/resources/views/";
    private $models_path = __DIR__ . "/Models/";
    private $config_path = __DIR__ . "/config/";
    private $database_path = __DIR__ . "/database/";
    private $routes_file = __DIR__ . "/routes/geo.php";

    /**
     * Get the services provided for deferred loading.
     *
     * @return array
     */
    public function provides(): array
    {
        return [Manager::class];
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Load the default config values
        $this->mergeConfigFrom(__DIR__ . '/config/breadcrumbs.php', 'breadcrumbs');

        // Register Manager class singleton with the app container
        $this->app->singleton(Manager::class, config('breadcrumbs.manager-class'));


    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish config/breadcrumbs.php file
        $this->publishes([
            __DIR__ . '/config/breadcrumbs.php' => config_path('breadcrumbs.php'),
        ], 'breadcrumbs-config');

        //Views



        if($this->app->has('view')){
            $this->loadViewsFrom($this->views_path, 'breadcrumbs');

            $this->loadViewComponentsAs('lb', [
                BreadcrumbsRender::class,
            ]);

            //Blade::component('breadcrumbs', BreadcrumbsRender::class);

            $this->publishes([
                $this->views_path => resource_path('views/vendor/breadcrumbs'),
            ], 'views');
        }

        // Load the routes/breadcrumbs.php file
        $this->registerBreadcrumbs();
    }

    /**
     *
     * This method can be overridden in a child class. It is called by the boot() method, which Laravel calls
     * automatically when bootstrapping the application.
     *
     * @return void
     */
    public function registerBreadcrumbs(): void
    {
        $breadcrumbs = $this->app->make(Manager::class);
    }
}
