<?php
/**
 * LaravelProduct routes
 */
// Product
Route::group(
    ['prefix' => 'product', 'namespace' => 'Minhbang\LaravelProduct\Controllers\Frontend'],
    function () {
        Route::get('/', ['as' => 'product.index', 'uses' => 'ProductController@index']);
        Route::get('{product}/{slug}', ['as' => 'product.show', 'uses' => 'ProductController@show']);
    }
);


Route::group(
    ['prefix' => 'backend', 'namespace' => 'Minhbang\LaravelProduct\Controllers\Backend'],
    function () {
        // Manufacturer
        Route::group(['prefix' => 'manufacturer', 'as' => 'backend.manufacturer.'], function () {
            Route::get('data', ['as' => 'data', 'uses' => 'ManufacturerController@data']);
            Route::post('order', ['as' => 'order', 'uses' => 'ManufacturerController@order']);
        });
        Route::resource('manufacturer', 'ManufacturerController');

        // Product
        Route::group(['prefix' => 'product', 'as' => 'backend.product.'], function () {
            Route::get('data', ['as' => 'data', 'uses' => 'ProductController@data']);
            Route::post('order', ['as' => 'order', 'uses' => 'ProductController@order']);
        });
        Route::resource('product', 'ProductController');
    }
);
