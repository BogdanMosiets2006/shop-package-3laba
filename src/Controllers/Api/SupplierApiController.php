<?php

namespace Vendor\ShopPackage\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Vendor\ShopPackage\Controllers\BaseController;
use Vendor\ShopPackage\Models\Supplier;

class SupplierApiController extends BaseController
{
    public function index(): JsonResponse
    {
        return response()->json(Supplier::withCount('products')->paginate(15));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:shop_suppliers,email',
            'phone'          => 'nullable|string|max:30',
            'address'        => 'nullable|string|max:255',
            'city'           => 'nullable|string|max:100',
            'country'        => 'nullable|string|max:100',
            'contact_person' => 'nullable|string|max:255',
        ]);
        return response()->json(Supplier::create($data), 201);
    }

    public function show(Supplier $supplier): JsonResponse
    {
        return response()->json($supplier->load('products'));
    }

    public function update(Request $request, Supplier $supplier): JsonResponse
    {
        $data = $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:shop_suppliers,email,' . $supplier->id,
            'phone'          => 'nullable|string|max:30',
            'address'        => 'nullable|string|max:255',
            'city'           => 'nullable|string|max:100',
            'country'        => 'nullable|string|max:100',
            'contact_person' => 'nullable|string|max:255',
        ]);
        $supplier->update($data);
        return response()->json($supplier);
    }

    public function destroy(Supplier $supplier): JsonResponse
    {
        $supplier->delete();
        return response()->json(['message' => 'Поставщик удалён.']);
    }
}
