<?php

namespace Vendor\ShopPackage\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Vendor\ShopPackage\Models\Category;
use Vendor\ShopPackage\Models\Product;
use Vendor\ShopPackage\Models\Supplier;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = $this->faker->words(3, true);

        return [
            'name'        => ucfirst($name),
            'slug'        => Str::slug($name) . '-' . $this->faker->unique()->numberBetween(1000, 9999),
            'description' => $this->faker->paragraph(),
            'price'       => $this->faker->randomFloat(2, 5, 5000),
            'weight'      => $this->faker->randomFloat(3, 0.1, 50),
            'sku'         => strtoupper($this->faker->unique()->bothify('SKU-####-??')),
            'is_active'   => $this->faker->boolean(90),
            'category_id' => Category::factory(),
            'supplier_id' => Supplier::factory(),
        ];
    }

    public function inactive(): static
    {
        return $this->state(['is_active' => false]);
    }
}
