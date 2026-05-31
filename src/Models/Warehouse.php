<?php

namespace Vendor\ShopPackage\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Warehouse extends Model
{
    use HasFactory;

    protected $table = 'shop_warehouses';

    protected $fillable = [
        'name',
        'address',
        'city',
        'country',
        'latitude',
        'longitude',
        'manager_name',
        'phone',
    ];

    protected $casts = [
        'latitude'  => 'float',
        'longitude' => 'float',
    ];

    protected static function newFactory()
    {
        return \Vendor\ShopPackage\Database\Factories\WarehouseFactory::new();
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'shop_product_warehouse')
            ->withPivot('quantity')
            ->withTimestamps();
    }
}
