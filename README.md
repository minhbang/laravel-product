# Laravel Product

## Install

* **Thêm vào file composer.json của app**
```json
	"repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/minhbang/laravel-product"
        }
    ],
    "require": {
        "minhbang/laravel-product": "dev-master"
    }
```
``` bash
$ composer update
```

* **Thêm vào file config/app.php => 'providers'**
```php
	Minhbang\LaravelProduct\ProductServiceProvider::class,
```

* **Publish config và database migrations**
```bash
$ php artisan vendor:publish
$ php artisan migrate
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
