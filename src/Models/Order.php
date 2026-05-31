<?php

namespace Vendor\ShopPackage\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;

    protected $table = 'shop_orders';

    protected $fillable = [
        'client_id',
        'status',
        'total_price',
        'delivery_address',
        'delivery_city',
        'delivery_country',
        'notes',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
    ];

    const STATUS_PENDING   = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_SHIPPED   = 'shipped';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_CANCELLED = 'cancelled';

    protected static function newFactory()
    {
        return \Vendor\ShopPackage\Database\Factories\OrderFactory::new();
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'shop_order_product')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }

    public function recalculateTotal(): void
    {
        $total = $this->products->sum(fn($p) => $p->pivot->price * $p->pivot->quantity);
        $this->update(['total_price' => $total]);
    }
}
