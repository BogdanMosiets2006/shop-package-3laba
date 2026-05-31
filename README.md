# Shop Package

Laravel-пакет для абстрактного интернет-магазина.

## Установка

```bash
composer require vendor/shop-package
```

## Публикация ресурсов

```bash
# Конфигурация
php artisan vendor:publish --tag=shop-config

# Миграции
php artisan vendor:publish --tag=shop-migrations
php artisan migrate

# Шаблоны страниц
php artisan vendor:publish --tag=shop-views

# Тесты
php artisan vendor:publish --tag=shop-tests
```

## Заполнение базы тестовыми данными

```php
// database/seeders/DatabaseSeeder.php
use Vendor\ShopPackage\Database\Seeders\ShopSeeder;

public function run(): void
{
    $this->call(ShopSeeder::class);
}
```

```bash
php artisan db:seed
```

## Настройка конфигурации

После публикации в `config/shop.php`:

```php
// Префикс web-маршрутов (по умолчанию: 'shop')
'route_prefix' => 'shop',

// Префикс API-маршрутов (по умолчанию: 'api/shop')
'api_prefix' => 'api/shop',

// Требуемая версия API для middleware
'api_version' => 1,

// Драйвер расчёта доставки: 'haversine' | 'nominatim' | 'openrouteservice'
'delivery' => [
    'driver' => 'haversine',
],
```

## Использование фасадов

```php
use Vendor\ShopPackage\Facades\CurrencyRate;
use Vendor\ShopPackage\Facades\DeliveryCalculator;

// Получить курс EUR к базовой валюте (USD)
$rate = CurrencyRate::getRate('EUR');

// Конвертировать 100 USD в EUR
$amount = CurrencyRate::convert(100, 'USD', 'EUR');

// Рассчитать доставку (Haversine — координаты "lat,lon")
$delivery = DeliveryCalculator::calculate('55.7558,37.6173', '59.9343,30.3351');
// ['distance_km' => 634.5, 'cost' => 317.25, 'driver' => 'haversine']

// Принудительно через Nominatim (адреса в произвольном виде)
$delivery = DeliveryCalculator::calculateByNominatim('Москва', 'Санкт-Петербург');

// Принудительно через OpenRouteService
$delivery = DeliveryCalculator::calculateByOpenRouteService('Москва', 'Казань');
```

## Middleware X-API-VERSION

Пакет регистрирует middleware `Vendor\ShopPackage\Http\Middleware\CheckApiVersion`.

Подключение в маршрутах приложения:

```php
// Для всего маршрута — версия из конфига
Route::get('/data', SomeController::class)->middleware(CheckApiVersion::class);

// Версия задана явно для конкретного маршрута
Route::get('/v2/data', SomeController::class)->middleware('check.api.version:2');
```

Регистрация алиаса в `app/Http/Kernel.php`:

```php
protected $routeMiddleware = [
    'check.api.version' => \Vendor\ShopPackage\Http\Middleware\CheckApiVersion::class,
];
```

## API

Все API-маршруты доступны по префиксу `api/shop` и требуют заголовок `X-API-VERSION: 1`.

| Метод  | Маршрут                   | Описание            |
|--------|---------------------------|---------------------|
| GET    | /api/shop/products        | Список товаров      |
| POST   | /api/shop/products        | Создать товар       |
| GET    | /api/shop/products/{id}   | Получить товар      |
| PUT    | /api/shop/products/{id}   | Обновить товар      |
| DELETE | /api/shop/products/{id}   | Удалить товар       |

Аналогично для: `categories`, `suppliers`, `clients`, `warehouses`, `orders`.

## Запуск тестов

```bash
composer test
# или
./vendor/bin/phpunit
```
