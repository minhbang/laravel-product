<?php

namespace Minhbang\LaravelProduct;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class ProductServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'product');
        $this->loadViewsFrom(__DIR__ . '/../views', 'product');
        $this->publishes(
            [
                __DIR__ . '/../views'                              => base_path('resources/views/vendor/product'),
                __DIR__ . '/../lang'                               => base_path('resources/lang/vendor/product'),
                __DIR__ . '/../config/product.php'                 => config_path('product.php'),
                __DIR__ . '/../database/migrations/' .
                '2015_07_21_211026_create_manufacturers_table.php' =>
                    database_path('migrations/2015_07_21_211026_create_manufacturers_table.php'),
                __DIR__ . '/../database/migrations/' .
                '2015_07_23_112625_create_products_table.php'      =>
                    database_path('migrations/2015_07_23_112625_create_products_table.php'),
            ]
        );

        if (config('product.add_route') && !$this->app->routesAreCached()) {
            require __DIR__ . '/routes.php';
        }
        // pattern filters
        $router->pattern('product', '[0-9]+');
        $router->pattern('manufacturer', '[0-9]+');
        // model bindings
        $router->model('product', 'Minhbang\LaravelProduct\Models\Product');
        $router->model('manufacturer', 'Minhbang\LaravelProduct\Models\Manufacturer');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/product.php', 'product');
    }
}
