<?php

namespace Vendor\ShopPackage\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static float  getRate(string $currency)
 * @method static array  getRates()
 * @method static float  convert(float $amount, string $from, string $to)
 */
class CurrencyRate extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'currency-rate';
    }
}
