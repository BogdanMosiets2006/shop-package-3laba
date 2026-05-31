<?php

namespace Vendor\ShopPackage\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Vendor\ShopPackage\Controllers\BaseController;
use Vendor\ShopPackage\Models\Category;

class CategoryApiController extends BaseController
{
    public function index(): JsonResponse
    {
        return response()->json(Category::withCount('products')->paginate(15));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'required|string|unique:shop_categories,slug',
            'description' => 'nullable|string',
            'parent_id'   => 'nullable|exists:shop_categories,id',
        ]);
        return response()->json(Category::create($data), 201);
    }

    public function show(Category $category): JsonResponse
    {
        return response()->json($category->load(['products', 'children', 'parent']));
    }

    public function update(Request $request, Category $category): JsonResponse
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'required|string|unique:shop_categories,slug,' . $category->id,
            'description' => 'nullable|string',
            'parent_id'   => 'nullable|exists:shop_categories,id',
        ]);
        $category->update($data);
        return response()->json($category);
    }

    public function destroy(Category $category): JsonResponse
    {
        $category->delete();
        return response()->json(['message' => 'Категория удалена.']);
    }
}
