<?php

namespace Vendor\ShopPackage\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Vendor\ShopPackage\Controllers\BaseController;
use Vendor\ShopPackage\Models\Warehouse;

class WarehouseApiController extends BaseController
{
    public function index(): JsonResponse
    {
        return response()->json(Warehouse::withCount('products')->paginate(15));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name'         => 'required|string|max:255',
            'address'      => 'required|string|max:255',
            'city'         => 'required|string|max:100',
            'country'      => 'required|string|max:100',
            'latitude'     => 'nullable|numeric|between:-90,90',
            'longitude'    => 'nullable|numeric|between:-180,180',
            'manager_name' => 'nullable|string|max:255',
            'phone'        => 'nullable|string|max:30',
        ]);
        return response()->json(Warehouse::create($data), 201);
    }

    public function show(Warehouse $warehouse): JsonResponse
    {
        return response()->json($warehouse->load('products'));
    }

    public function update(Request $request, Warehouse $warehouse): JsonResponse
    {
        $data = $request->validate([
            'name'         => 'required|string|max:255',
            'address'      => 'required|string|max:255',
            'city'         => 'required|string|max:100',
            'country'      => 'required|string|max:100',
            'latitude'     => 'nullable|numeric|between:-90,90',
            'longitude'    => 'nullable|numeric|between:-180,180',
            'manager_name' => 'nullable|string|max:255',
            'phone'        => 'nullable|string|max:30',
        ]);
        $warehouse->update($data);
        return response()->json($warehouse);
    }

    public function destroy(Warehouse $warehouse): JsonResponse
    {
        $warehouse->delete();
        return response()->json(['message' => 'Склад удалён.']);
    }
}
