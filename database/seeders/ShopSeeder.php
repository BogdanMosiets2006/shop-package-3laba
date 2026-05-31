<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Vendor\ShopPackage\Models\Category;
use Vendor\ShopPackage\Models\Client;
use Vendor\ShopPackage\Models\Order;
use Vendor\ShopPackage\Models\Product;
use Vendor\ShopPackage\Models\Supplier;
use Vendor\ShopPackage\Models\Warehouse;

class ShopSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::factory(5)->create();
        $suppliers  = Supplier::factory(10)->create();
        $warehouses = Warehouse::factory(5)->create();
        $clients    = Client::factory(20)->create();

        $products = Product::factory(30)->create([
            'category_id' => fn() => $categories->random()->id,
            'supplier_id' => fn() => $suppliers->random()->id,
        ]);

        $products->each(function ($product) use ($warehouses) {
            $product->warehouses()->attach(
                $warehouses->random(rand(1, 3))
                    ->mapWithKeys(fn($w) => [$w->id => ['quantity' => rand(10, 100)]])
                    ->toArray()
            );
        });

        $clients->each(function ($client) use ($products) {
            $orders = Order::factory(rand(1, 3))->create(['client_id' => $client->id]);
            $orders->each(function ($order) use ($products) {
                $order->products()->attach(
                    $products->random(rand(1, 4))
                        ->mapWithKeys(fn($p) => [$p->id => ['quantity' => rand(1, 5), 'price' => $p->price]])
                        ->toArray()
                );
                $order->recalculateTotal();
            });
        });
    }
}
