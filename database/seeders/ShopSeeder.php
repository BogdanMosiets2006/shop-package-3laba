<?php

namespace Vendor\ShopPackage\Database\Seeders;

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
        // Создаём корневые категории
        $categories = Category::factory(5)->create();

        // Подкатегории
        $categories->each(function (Category $parent) {
            Category::factory(3)->withParent($parent->id)->create();
        });

        $suppliers  = Supplier::factory(10)->create();
        $warehouses = Warehouse::factory(5)->create();
        $clients    = Client::factory(30)->create();

        // Товары привязываем к существующим категориям и поставщикам
        $allCategories = Category::all();
        $allSuppliers  = Supplier::all();

        $products = Product::factory(50)->create([
            'category_id' => fn() => $allCategories->random()->id,
            'supplier_id' => fn() => $allSuppliers->random()->id,
        ]);

        // Связываем товары со складами
        $products->each(function (Product $product) use ($warehouses) {
            $subset = $warehouses->random(rand(1, 3));
            $product->warehouses()->attach(
                $subset->mapWithKeys(fn($w) => [$w->id => ['quantity' => rand(0, 200)]])->toArray()
            );
        });

        // Создаём заказы
        $clients->each(function (Client $client) use ($products) {
            $orders = Order::factory(rand(1, 4))->create(['client_id' => $client->id]);

            $orders->each(function (Order $order) use ($products) {
                $subset = $products->random(rand(1, 5));
                $order->products()->attach(
                    $subset->mapWithKeys(fn($p) => [
                        $p->id => [
                            'quantity' => rand(1, 10),
                            'price'    => $p->price,
                        ],
                    ])->toArray()
                );
                $order->recalculateTotal();
            });
        });
    }
}
