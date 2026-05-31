<?php

namespace Vendor\ShopPackage\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Vendor\ShopPackage\Controllers\BaseController;
use Vendor\ShopPackage\Models\Order;
use Vendor\ShopPackage\Models\Product;

class OrderApiController extends BaseController
{
    public function index(): JsonResponse
    {
        return response()->json(Order::with('client')->paginate(15));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'client_id'        => 'required|exists:shop_clients,id',
            'status'           => 'in:pending,confirmed,shipped,delivered,cancelled',
            'delivery_address' => 'nullable|string|max:255',
            'delivery_city'    => 'nullable|string|max:100',
            'delivery_country' => 'nullable|string|max:100',
            'notes'            => 'nullable|string',
            'products'         => 'required|array|min:1',
            'products.*.id'    => 'required|exists:shop_products,id',
            'products.*.qty'   => 'required|integer|min:1',
        ]);

        $order = Order::create([
            ...$data,
            'status'      => $data['status'] ?? Order::STATUS_PENDING,
            'total_price' => 0,
        ]);

        foreach ($data['products'] as $item) {
            $product = Product::findOrFail($item['id']);
            $order->products()->attach($product->id, [
                'quantity' => $item['qty'],
                'price'    => $product->price,
            ]);
        }
        $order->recalculateTotal();

        return response()->json($order->load(['client', 'products']), 201);
    }

    public function show(Order $order): JsonResponse
    {
        return response()->json($order->load(['client', 'products']));
    }

    public function update(Request $request, Order $order): JsonResponse
    {
        $data = $request->validate([
            'client_id'        => 'required|exists:shop_clients,id',
            'status'           => 'required|in:pending,confirmed,shipped,delivered,cancelled',
            'delivery_address' => 'nullable|string|max:255',
            'delivery_city'    => 'nullable|string|max:100',
            'delivery_country' => 'nullable|string|max:100',
            'notes'            => 'nullable|string',
        ]);
        $order->update($data);
        return response()->json($order);
    }

    public function destroy(Order $order): JsonResponse
    {
        $order->delete();
        return response()->json(['message' => 'Заказ удалён.']);
    }
}
