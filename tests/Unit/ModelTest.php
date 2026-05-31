<?php

namespace Vendor\ShopPackage\Tests\Unit;

use Vendor\ShopPackage\Models\Category;
use Vendor\ShopPackage\Models\Client;
use Vendor\ShopPackage\Models\Order;
use Vendor\ShopPackage\Models\Product;
use Vendor\ShopPackage\Models\Supplier;
use Vendor\ShopPackage\Models\Warehouse;
use Vendor\ShopPackage\Tests\TestCase;

class ModelTest extends TestCase
{
    /** @test */
    public function category_can_be_created_via_factory(): void
    {
        $category = Category::factory()->create();

        $this->assertNotNull($category->id);
        $this->assertNotEmpty($category->name);
        $this->assertNotEmpty($category->slug);
        $this->assertDatabaseHas('shop_categories', ['id' => $category->id]);
    }

    /** @test */
    public function category_can_have_parent(): void
    {
        $parent = Category::factory()->create();
        $child  = Category::factory()->withParent($parent->id)->create();

        $this->assertEquals($parent->id, $child->parent_id);
        $this->assertEquals($parent->id, $child->parent->id);
    }

    /** @test */
    public function supplier_can_be_created_via_factory(): void
    {
        $supplier = Supplier::factory()->create();

        $this->assertNotNull($supplier->id);
        $this->assertNotEmpty($supplier->email);
        $this->assertDatabaseHas('shop_suppliers', ['id' => $supplier->id]);
    }

    /** @test */
    public function product_belongs_to_category_and_supplier(): void
    {
        $product = Product::factory()->create();

        $this->assertInstanceOf(Category::class, $product->category);
        $this->assertInstanceOf(Supplier::class, $product->supplier);
    }

    /** @test */
    public function product_price_is_cast_to_decimal(): void
    {
        $product = Product::factory()->create(['price' => '99.99']);

        $this->assertEquals(99.99, (float) $product->price);
    }

    /** @test */
    public function client_full_name_accessor_works(): void
    {
        $client = Client::factory()->create([
            'first_name' => 'Иван',
            'last_name'  => 'Петров',
        ]);

        $this->assertEquals('Иван Петров', $client->full_name);
    }

    /** @test */
    public function warehouse_can_be_created_via_factory(): void
    {
        $warehouse = Warehouse::factory()->create();

        $this->assertNotNull($warehouse->id);
        $this->assertNotEmpty($warehouse->city);
        $this->assertDatabaseHas('shop_warehouses', ['id' => $warehouse->id]);
    }

    /** @test */
    public function order_has_correct_status_constants(): void
    {
        $this->assertEquals('pending',   Order::STATUS_PENDING);
        $this->assertEquals('confirmed', Order::STATUS_CONFIRMED);
        $this->assertEquals('shipped',   Order::STATUS_SHIPPED);
        $this->assertEquals('delivered', Order::STATUS_DELIVERED);
        $this->assertEquals('cancelled', Order::STATUS_CANCELLED);
    }

    /** @test */
    public function order_recalculate_total_works(): void
    {
        $client  = Client::factory()->create();
        $product = Product::factory()->create(['price' => 100.00]);
        $order   = Order::factory()->create(['client_id' => $client->id, 'total_price' => 0]);

        $order->products()->attach($product->id, ['quantity' => 3, 'price' => 100.00]);
        $order->recalculateTotal();

        $this->assertEquals(300.00, (float) $order->fresh()->total_price);
    }

    /** @test */
    public function product_warehouse_pivot_stores_quantity(): void
    {
        $product   = Product::factory()->create();
        $warehouse = Warehouse::factory()->create();

        $product->warehouses()->attach($warehouse->id, ['quantity' => 50]);

        $this->assertDatabaseHas('shop_product_warehouse', [
            'product_id'   => $product->id,
            'warehouse_id' => $warehouse->id,
            'quantity'     => 50,
        ]);
    }

    /** @test */
    public function inactive_product_factory_state_works(): void
    {
        $product = Product::factory()->inactive()->create();

        $this->assertFalse($product->is_active);
    }
}
