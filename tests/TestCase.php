<?php

namespace Vendor\ShopPackage\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Vendor\ShopPackage\ShopServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app): array
    {
        return [ShopServiceProvider::class];
    }

    protected function getPackageAliases($app): array
    {
        return [
            'CurrencyRate'        => \Vendor\ShopPackage\Facades\CurrencyRate::class,
            'DeliveryCalculator'  => \Vendor\ShopPackage\Facades\DeliveryCalculator::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}
