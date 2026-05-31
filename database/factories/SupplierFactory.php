<?php

namespace Vendor\ShopPackage\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Vendor\ShopPackage\Models\Supplier;

class SupplierFactory extends Factory
{
    protected $model = Supplier::class;

    public function definition(): array
    {
        return [
            'name'           => $this->faker->company(),
            'email'          => $this->faker->unique()->companyEmail(),
            'phone'          => $this->faker->phoneNumber(),
            'address'        => $this->faker->streetAddress(),
            'city'           => $this->faker->city(),
            'country'        => $this->faker->country(),
            'contact_person' => $this->faker->name(),
        ];
    }
}
