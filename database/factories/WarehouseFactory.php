<?php

namespace Vendor\ShopPackage\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Vendor\ShopPackage\Models\Warehouse;

class WarehouseFactory extends Factory
{
    protected $model = Warehouse::class;

    public function definition(): array
    {
        return [
            'name'         => $this->faker->company() . ' Warehouse',
            'address'      => $this->faker->streetAddress(),
            'city'         => $this->faker->city(),
            'country'      => $this->faker->country(),
            'latitude'     => $this->faker->latitude(),
            'longitude'    => $this->faker->longitude(),
            'manager_name' => $this->faker->name(),
            'phone'        => $this->faker->phoneNumber(),
        ];
    }
}
