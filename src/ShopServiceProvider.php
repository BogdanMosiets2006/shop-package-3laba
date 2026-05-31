<?php

namespace Vendor\ShopPackage;

use Illuminate\Support\ServiceProvider;
use Vendor\ShopPackage\Services\CurrencyRateService;
use Vendor\ShopPackage\Services\DeliveryCalculatorService;

class ShopServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/shop.php', 'shop');

        $this->app->singleton('currency-rate', function ($app) {
            return new CurrencyRateService(config('shop.currency'));
        });

        $this->app->singleton('delivery-calculator', function ($app) {
            return new DeliveryCalculatorService(config('shop.delivery'));
        });
    }

    public function boot(): void
    {
        // Регистрация фабрик
        $this->app->singleton(\Illuminate\Database\Eloquent\Factories\Factory::class, function () {
            return \Illuminate\Database\Eloquent\Factories\Factory::factoryForModel('');
        });

        if ($this->app->runningInConsole()) {
            \Illuminate\Database\Eloquent\Factories\Factory::guessFactoryNamesUsing(
                fn(string $model) => 'Vendor\\ShopPackage\\Database\\Factories\\' . class_basename($model) . 'Factory'
            );
        }

        // Публикация конфигурации
        $this->publishes([
            __DIR__ . '/../config/shop.php' => config_path('shop.php'),
        ], 'shop-config');

        // Публикация миграций
        $this->publishes([
            __DIR__ . '/../database/migrations/' => database_path('migrations'),
        ], 'shop-migrations');

        // Публикация вьюх
        $this->publishes([
            __DIR__ . '/../resources/views/' => resource_path('views/vendor/shop'),
        ], 'shop-views');

        // Публикация тестов
        $this->publishes([
            __DIR__ . '/../tests/' => base_path('tests/Vendor/Shop'),
        ], 'shop-tests');

        // Загрузка вьюх из пакета
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'shop');

        // Загрузка миграций напрямую (без публикации)
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // Маршруты вызываются напрямую из пакета (не публикуются)
        $this->registerRoutes();
    }

    protected function registerRoutes(): void
    {
        $prefix = config('shop.route_prefix', 'shop');

        \Illuminate\Support\Facades\Route::group([
            'prefix'     => $prefix,
            'namespace'  => 'Vendor\\ShopPackage\\Controllers',
            'middleware' => config('shop.middleware', ['web']),
        ], function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        });

        \Illuminate\Support\Facades\Route::group([
            'prefix'     => config('shop.api_prefix', 'api/shop'),
            'namespace'  => 'Vendor\\ShopPackage\\Controllers\\Api',
            'middleware' => config('shop.api_middleware', ['api']),
        ], function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        });
    }
}
