<?php

namespace Vendor\ShopPackage\Tests\Unit;

use Vendor\ShopPackage\Services\DeliveryCalculatorService;
use Vendor\ShopPackage\Tests\TestCase;

class DeliveryCalculatorTest extends TestCase
{
    private DeliveryCalculatorService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new DeliveryCalculatorService([
            'driver'       => 'haversine',
            'rate_per_km'  => 0.5,
            'nominatim'    => ['url' => 'https://nominatim.openstreetmap.org', 'user_agent' => 'test'],
            'openrouteservice' => ['api_key' => '', 'url' => ''],
        ]);
    }

    /** @test */
    public function it_calculates_haversine_distance_between_two_coordinates(): void
    {
        // Москва → Санкт-Петербург (≈ 630 км по прямой)
        $result = $this->service->calculateByHaversine('55.7558,37.6173', '59.9343,30.3351');

        $this->assertArrayHasKey('distance_km', $result);
        $this->assertArrayHasKey('cost', $result);
        $this->assertArrayHasKey('driver', $result);
        $this->assertEquals('haversine', $result['driver']);

        // Допуск ±30 км
        $this->assertGreaterThan(600, $result['distance_km']);
        $this->assertLessThan(680, $result['distance_km']);
    }

    /** @test */
    public function it_returns_zero_distance_for_same_point(): void
    {
        $result = $this->service->calculateByHaversine('55.7558,37.6173', '55.7558,37.6173');

        $this->assertEquals(0.0, $result['distance_km']);
        $this->assertEquals(0.0, $result['cost']);
    }

    /** @test */
    public function cost_equals_distance_multiplied_by_rate(): void
    {
        $result = $this->service->calculateByHaversine('55.7558,37.6173', '59.9343,30.3351');

        $expected = round($result['distance_km'] * 0.5, 2);
        $this->assertEquals($expected, $result['cost']);
    }

    /** @test */
    public function it_uses_driver_from_config(): void
    {
        $service = new DeliveryCalculatorService([
            'driver'      => 'haversine',
            'rate_per_km' => 1.0,
            'nominatim'   => ['url' => '', 'user_agent' => 'test'],
            'openrouteservice' => ['api_key' => '', 'url' => ''],
        ]);

        $result = $service->calculate('55.7558,37.6173', '59.9343,30.3351');

        $this->assertEquals('haversine', $result['driver']);
    }

    /** @test */
    public function it_respects_rate_per_km_setting(): void
    {
        $serviceA = new DeliveryCalculatorService([
            'driver' => 'haversine', 'rate_per_km' => 1.0,
            'nominatim' => ['url' => '', 'user_agent' => 'test'],
            'openrouteservice' => ['api_key' => '', 'url' => ''],
        ]);
        $serviceB = new DeliveryCalculatorService([
            'driver' => 'haversine', 'rate_per_km' => 2.0,
            'nominatim' => ['url' => '', 'user_agent' => 'test'],
            'openrouteservice' => ['api_key' => '', 'url' => ''],
        ]);

        $a = $serviceA->calculateByHaversine('55.7558,37.6173', '59.9343,30.3351');
        $b = $serviceB->calculateByHaversine('55.7558,37.6173', '59.9343,30.3351');

        $this->assertEquals($a['distance_km'], $b['distance_km']);
        $this->assertEqualsWithDelta($b['cost'], $a['cost'] * 2, 0.01);
    }
}
