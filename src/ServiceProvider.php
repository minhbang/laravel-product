<?php

namespace Minhbang\Product;

use Illuminate\Routing\Router;
use Minhbang\Kit\Extensions\BaseServiceProvider;
use Minhbang\Enum\Enum;
use Minhbang\Product\Models\Manufacturer;
use Minhbang\Product\Models\Product;

class ServiceProvider extends BaseServiceProvider
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
                __DIR__ . '/../views'              => base_path('resources/views/vendor/product'),
                __DIR__ . '/../lang'               => base_path('resources/lang/vendor/product'),
                __DIR__ . '/../config/product.php' => config_path('product.php'),
            ]
        );
        $this->publishes(
            [
                __DIR__ . '/../database/migrations/2015_07_21_211026_create_manufacturers_table.php'        =>
                    database_path('migrations/2015_07_21_211026_create_manufacturers_table.php'),
                __DIR__ . '/../database/migrations/2015_07_23_112625_create_products_table.php'             =>
                    database_path('migrations/2015_07_23_112625_create_products_table.php'),
                __DIR__ . '/../database/migrations/2015_07_23_122625_create_product_translations_table.php' =>
                    database_path('migrations/2015_07_23_122625_create_product_translations_table.php'),
            ],
            'db'
        );

        $this->mapWebRoutes($router, __DIR__ . '/routes.php', config('product.add_route'));
        
        // pattern filters
        $router->pattern('product', '[0-9]+');
        $router->pattern('manufacturer', '[0-9]+');
        // model bindings
        $router->model('product', Product::class);
        $router->model('manufacturer', Manufacturer::class);

        Enum::registerResources([Product::class]);
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
