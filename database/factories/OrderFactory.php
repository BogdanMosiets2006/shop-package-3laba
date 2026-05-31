<?php

namespace Vendor\ShopPackage\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Vendor\ShopPackage\Models\Client;
use Vendor\ShopPackage\Models\Order;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'client_id'        => Client::factory(),
            'status'           => $this->faker->randomElement([
                Order::STATUS_PENDING,
                Order::STATUS_CONFIRMED,
                Order::STATUS_SHIPPED,
                Order::STATUS_DELIVERED,
                Order::STATUS_CANCELLED,
            ]),
            'total_price'      => $this->faker->randomFloat(2, 10, 10000),
            'delivery_address' => $this->faker->streetAddress(),
            'delivery_city'    => $this->faker->city(),
            'delivery_country' => $this->faker->country(),
            'notes'            => $this->faker->optional()->sentence(),
        ];
    }

    public function pending(): static
    {
        return $this->state(['status' => Order::STATUS_PENDING]);
    }

    public function delivered(): static
    {
        return $this->state(['status' => Order::STATUS_DELIVERED]);
    }
}
