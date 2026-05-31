<?php

namespace Vendor\ShopPackage\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Vendor\ShopPackage\Models\Client;

class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition(): array
    {
        return [
            'first_name'  => $this->faker->firstName(),
            'last_name'   => $this->faker->lastName(),
            'email'       => $this->faker->unique()->safeEmail(),
            'phone'       => $this->faker->phoneNumber(),
            'address'     => $this->faker->streetAddress(),
            'city'        => $this->faker->city(),
            'country'     => $this->faker->country(),
            'postal_code' => $this->faker->postcode(),
        ];
    }
}
