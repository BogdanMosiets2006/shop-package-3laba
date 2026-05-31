<?php

namespace Vendor\ShopPackage\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Vendor\ShopPackage\Models\Category;

class CategoryController extends BaseController
{
    public function index(): View
    {
        $categories = Category::withCount('products')->paginate(15);

        return view('shop::categories.index', compact('categories'));
    }

    public function create(): View
    {
        $parents = Category::whereNull('parent_id')->get();

        return view('shop::categories.create', compact('parents'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'required|string|unique:shop_categories,slug',
            'description' => 'nullable|string',
            'parent_id'   => 'nullable|exists:shop_categories,id',
        ]);

        Category::create($data);

        return redirect()->route('shop.categories.index')
            ->with('success', 'Категория создана.');
    }

    public function show(Category $category): View
    {
        $category->load(['products', 'children', 'parent']);

        return view('shop::categories.show', compact('category'));
    }

    public function edit(Category $category): View
    {
        $parents = Category::whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->get();

        return view('shop::categories.edit', compact('category', 'parents'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'required|string|unique:shop_categories,slug,' . $category->id,
            'description' => 'nullable|string',
            'parent_id'   => 'nullable|exists:shop_categories,id',
        ]);

        $category->update($data);

        return redirect()->route('shop.categories.index')
            ->with('success', 'Категория обновлена.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('shop.categories.index')
            ->with('success', 'Категория удалена.');
    }
}
