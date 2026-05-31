<?php

namespace Vendor\ShopPackage\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class CurrencyRateService
{
    protected Client $http;
    protected array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->http   = new Client(['timeout' => 5]);
    }

    /**
     * Получить курс валюты относительно базовой.
     */
    public function getRate(string $currency): float
    {
        $rates = $this->getRates();

        $currency = strtoupper($currency);

        if (!isset($rates[$currency])) {
            throw new \InvalidArgumentException("Валюта {$currency} не найдена.");
        }

        return (float) $rates[$currency];
    }

    /**
     * Получить все актуальные курсы (с кешированием).
     */
    public function getRates(): array
    {
        $base    = strtoupper($this->config['base'] ?? 'USD');
        $cacheKey = "shop_currency_rates_{$base}";
        $ttl      = $this->config['cache_ttl'] ?? 3600;

        return Cache::remember($cacheKey, $ttl, function () use ($base) {
            $url      = rtrim($this->config['api_url'], '/') . '/' . $base;
            $response = $this->http->get($url);
            $data     = json_decode($response->getBody()->getContents(), true);

            return $data['rates'] ?? [];
        });
    }

    /**
     * Конвертировать сумму из одной валюты в другую.
     */
    public function convert(float $amount, string $from, string $to): float
    {
        $rates = $this->getRates();
        $from  = strtoupper($from);
        $to    = strtoupper($to);
        $base  = strtoupper($this->config['base'] ?? 'USD');

        // Приводим к базовой, затем к целевой
        $inBase = ($from === $base) ? $amount : $amount / ($rates[$from] ?? 1);
        $result = ($to === $base) ? $inBase : $inBase * ($rates[$to] ?? 1);

        return round($result, 4);
    }
}
