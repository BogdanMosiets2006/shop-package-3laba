<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Префикс маршрутов
    |--------------------------------------------------------------------------
    | Внутренний префикс для web-маршрутов пакета.
    */
    'route_prefix' => env('SHOP_ROUTE_PREFIX', 'shop'),
    'api_prefix'   => env('SHOP_API_PREFIX', 'api/shop'),

    'middleware'     => ['web'],
    'api_middleware' => ['api'],

    /*
    |--------------------------------------------------------------------------
    | Версия API (для middleware X-API-VERSION)
    |--------------------------------------------------------------------------
    */
    'api_version' => env('SHOP_API_VERSION', 1),

    /*
    |--------------------------------------------------------------------------
    | Настройки курса валют
    |--------------------------------------------------------------------------
    */
    'currency' => [
        'base'     => env('SHOP_CURRENCY_BASE', 'USD'),
        'api_url'  => env('SHOP_CURRENCY_API', 'https://api.exchangerate-api.com/v4/latest/'),
        'cache_ttl' => 3600, // секунды
    ],

    /*
    |--------------------------------------------------------------------------
    | Настройки расчёта доставки
    |--------------------------------------------------------------------------
    | driver: 'openrouteservice' | 'nominatim' | 'haversine'
    */
    'delivery' => [
        'driver'    => env('SHOP_DELIVERY_DRIVER', 'haversine'),
        'rate_per_km' => env('SHOP_DELIVERY_RATE', 0.5), // стоимость за км в базовой валюте

        'openrouteservice' => [
            'api_key' => env('ORS_API_KEY', ''),
            'url'     => 'https://api.openrouteservice.org/v2/directions/driving-car',
        ],

        'nominatim' => [
            'url'        => 'https://nominatim.openstreetmap.org',
            'user_agent' => env('APP_NAME', 'ShopPackage'),
        ],
    ],
];
