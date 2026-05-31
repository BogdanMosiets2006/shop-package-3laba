<?php

namespace Vendor\ShopPackage\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Vendor\ShopPackage\Models\Category;
use Vendor\ShopPackage\Models\Product;
use Vendor\ShopPackage\Models\Supplier;

class ProductController extends BaseController
{
    public function index(): View
    {
        $products = Product::with(['category', 'supplier'])->paginate(15);

        return view('shop::products.index', compact('products'));
    }

    public function create(): View
    {
        $categories = Category::all();
        $suppliers  = Supplier::all();

        return view('shop::products.create', compact('categories', 'suppliers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'required|string|unique:shop_products,slug',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'weight'      => 'nullable|numeric|min:0',
            'sku'         => 'nullable|string|unique:shop_products,sku',
            'is_active'   => 'boolean',
            'category_id' => 'nullable|exists:shop_categories,id',
            'supplier_id' => 'nullable|exists:shop_suppliers,id',
        ]);

        $data['is_active'] = $request->boolean('is_active', true);

        Product::create($data);

        return redirect()->route('shop.products.index')
            ->with('success', 'Товар успешно добавлен.');
    }

    public function show(Product $product): View
    {
        $product->load(['category', 'supplier', 'warehouses']);

        return view('shop::products.show', compact('product'));
    }

    public function edit(Product $product): View
    {
        $categories = Category::all();
        $suppliers  = Supplier::all();

        return view('shop::products.edit', compact('product', 'categories', 'suppliers'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'required|string|unique:shop_products,slug,' . $product->id,
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'weight'      => 'nullable|numeric|min:0',
            'sku'         => 'nullable|string|unique:shop_products,sku,' . $product->id,
            'is_active'   => 'boolean',
            'category_id' => 'nullable|exists:shop_categories,id',
            'supplier_id' => 'nullable|exists:shop_suppliers,id',
        ]);

        $data['is_active'] = $request->boolean('is_active', true);

        $product->update($data);

        return redirect()->route('shop.products.index')
            ->with('success', 'Товар обновлён.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('shop.products.index')
            ->with('success', 'Товар удалён.');
    }
}
