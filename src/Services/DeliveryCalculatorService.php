<?php

namespace Vendor\ShopPackage\Services;

use GuzzleHttp\Client;

class DeliveryCalculatorService
{
    protected Client $http;
    protected array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->http   = new Client(['timeout' => 10]);
    }

    /**
     * Рассчитать стоимость доставки согласно выбранному драйверу из конфига.
     *
     * @param  string $from  Адрес/название точки отправки
     * @param  string $to    Адрес/название точки назначения
     * @return array ['distance_km' => float, 'cost' => float, 'driver' => string]
     */
    public function calculate(string $from, string $to): array
    {
        $driver = $this->config['driver'] ?? 'haversine';

        return match ($driver) {
            'openrouteservice' => $this->calculateByOpenRouteService($from, $to),
            'nominatim'        => $this->calculateByNominatim($from, $to),
            default            => $this->calculateByHaversine($from, $to),
        };
    }

    /**
     * Метод 1: OpenRouteService — реальный маршрут по дорогам.
     */
    public function calculateByOpenRouteService(string $from, string $to): array
    {
        $apiKey = $this->config['openrouteservice']['api_key'] ?? '';
        $url    = $this->config['openrouteservice']['url'];

        [$latFrom, $lonFrom] = $this->geocodeNominatim($from);
        [$latTo,   $lonTo]   = $this->geocodeNominatim($to);

        $response = $this->http->post($url, [
            'headers' => [
                'Authorization' => $apiKey,
                'Content-Type'  => 'application/json',
            ],
            'json' => [
                'coordinates' => [
                    [$lonFrom, $latFrom],
                    [$lonTo,   $latTo],
                ],
            ],
        ]);

        $data       = json_decode($response->getBody()->getContents(), true);
        $distanceM  = $data['routes'][0]['summary']['distance'] ?? 0;
        $distanceKm = round($distanceM / 1000, 2);

        return [
            'distance_km' => $distanceKm,
            'cost'        => $this->computeCost($distanceKm),
            'driver'      => 'openrouteservice',
        ];
    }

    /**
     * Метод 2: Nominatim (OpenStreetMap) — геокодирование + формула Хаверсина.
     */
    public function calculateByNominatim(string $from, string $to): array
    {
        [$latFrom, $lonFrom] = $this->geocodeNominatim($from);
        [$latTo,   $lonTo]   = $this->geocodeNominatim($to);

        $distanceKm = $this->haversine($latFrom, $lonFrom, $latTo, $lonTo);

        return [
            'distance_km' => $distanceKm,
            'cost'        => $this->computeCost($distanceKm),
            'driver'      => 'nominatim',
        ];
    }

    /**
     * Метод 3: Математический — формула Хаверсина по координатам.
     * $from и $to передаются в формате "lat,lon".
     */
    public function calculateByHaversine(string $from, string $to): array
    {
        [$latFrom, $lonFrom] = array_map('floatval', explode(',', $from));
        [$latTo,   $lonTo]   = array_map('floatval', explode(',', $to));

        $distanceKm = $this->haversine($latFrom, $lonFrom, $latTo, $lonTo);

        return [
            'distance_km' => $distanceKm,
            'cost'        => $this->computeCost($distanceKm),
            'driver'      => 'haversine',
        ];
    }

    /**
     * Формула Хаверсина — расстояние по поверхности земного шара (км).
     */
    protected function haversine(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $earthRadius = 6371.0; // км

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) ** 2
            + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) ** 2;

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return round($earthRadius * $c, 2);
    }

    /**
     * Геокодирование через Nominatim (OSM).
     */
    protected function geocodeNominatim(string $place): array
    {
        $url       = rtrim($this->config['nominatim']['url'], '/') . '/search';
        $userAgent = $this->config['nominatim']['user_agent'] ?? 'ShopPackage';

        $response = $this->http->get($url, [
            'headers' => ['User-Agent' => $userAgent],
            'query'   => [
                'q'      => $place,
                'format' => 'json',
                'limit'  => 1,
            ],
        ]);

        $results = json_decode($response->getBody()->getContents(), true);

        if (empty($results)) {
            throw new \RuntimeException("Место не найдено: {$place}");
        }

        return [(float) $results[0]['lat'], (float) $results[0]['lon']];
    }

    protected function computeCost(float $distanceKm): float
    {
        $rate = $this->config['rate_per_km'] ?? 0.5;

        return round($distanceKm * $rate, 2);
    }
}
