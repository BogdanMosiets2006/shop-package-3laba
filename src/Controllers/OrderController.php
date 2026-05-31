<?php

namespace Vendor\ShopPackage\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Vendor\ShopPackage\Models\Client;
use Vendor\ShopPackage\Models\Order;
use Vendor\ShopPackage\Models\Product;

class OrderController extends BaseController
{
    public function index(): View
    {
        $orders = Order::with('client')->paginate(15);

        return view('shop::orders.index', compact('orders'));
    }

    public function create(): View
    {
        $clients  = Client::all();
        $products = Product::where('is_active', true)->get();

        return view('shop::orders.create', compact('clients', 'products'));
    }

    public function store(Request $request): RedirectResponse
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
            'client_id'        => $data['client_id'],
            'status'           => $data['status'] ?? Order::STATUS_PENDING,
            'delivery_address' => $data['delivery_address'] ?? null,
            'delivery_city'    => $data['delivery_city'] ?? null,
            'delivery_country' => $data['delivery_country'] ?? null,
            'notes'            => $data['notes'] ?? null,
            'total_price'      => 0,
        ]);

        foreach ($data['products'] as $item) {
            $product = Product::findOrFail($item['id']);
            $order->products()->attach($product->id, [
                'quantity' => $item['qty'],
                'price'    => $product->price,
            ]);
        }

        $order->recalculateTotal();

        return redirect()->route('shop.orders.index')
            ->with('success', 'Заказ создан.');
    }

    public function show(Order $order): View
    {
        $order->load(['client', 'products']);

        return view('shop::orders.show', compact('order'));
    }

    public function edit(Order $order): View
    {
        $clients  = Client::all();
        $products = Product::where('is_active', true)->get();
        $order->load('products');

        return view('shop::orders.edit', compact('order', 'clients', 'products'));
    }

    public function update(Request $request, Order $order): RedirectResponse
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

        return redirect()->route('shop.orders.index')
            ->with('success', 'Заказ обновлён.');
    }

    public function destroy(Order $order): RedirectResponse
    {
        $order->delete();

        return redirect()->route('shop.orders.index')
            ->with('success', 'Заказ удалён.');
    }
}
