<?php

namespace Vendor\ShopPackage\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array calculate(string $from, string $to)
 * @method static array calculateByOpenRouteService(string $from, string $to)
 * @method static array calculateByNominatim(string $from, string $to)
 * @method static array calculateByHaversine(string $from, string $to)
 */
class DeliveryCalculator extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'delivery-calculator';
    }
}
