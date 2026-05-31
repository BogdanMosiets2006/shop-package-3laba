<?php

namespace Vendor\ShopPackage\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $table = 'shop_products';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'weight',
        'category_id',
        'supplier_id',
        'sku',
        'is_active',
    ];

    protected $casts = [
        'price'     => 'decimal:2',
        'weight'    => 'decimal:3',
        'is_active' => 'boolean',
    ];

    protected static function newFactory()
    {
        return \Vendor\ShopPackage\Database\Factories\ProductFactory::new();
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function warehouses(): BelongsToMany
    {
        return $this->belongsToMany(Warehouse::class, 'shop_product_warehouse')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'shop_order_product')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }
}
