<?php

namespace Vendor\ShopPackage\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Vendor\ShopPackage\Controllers\BaseController;
use Vendor\ShopPackage\Http\Requests\ProductRequest;
use Vendor\ShopPackage\Http\Resources\ProductResource;
use Vendor\ShopPackage\Http\Resources\ProductCollection;
use Vendor\ShopPackage\Models\Product;

class ProductApiController extends BaseController
{
    public function index(): ProductCollection
    {
        $products = Product::with(['category', 'supplier'])->paginate(15);

        return new ProductCollection($products);
    }

    public function store(ProductRequest $request): JsonResponse
    {
        $product = Product::create($request->validated());

        return (new ProductResource($product->load(['category', 'supplier'])))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Product $product): ProductResource
    {
        return new ProductResource($product->load(['category', 'supplier']));
    }

    public function update(ProductRequest $request, Product $product): ProductResource
    {
        $product->update($request->validated());

        return new ProductResource($product->load(['category', 'supplier']));
    }

    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return response()->json(['message' => 'Товар удалён.']);
    }
}
