<?php

namespace Vendor\ShopPackage\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Vendor\ShopPackage\Models\Warehouse;

class WarehouseController extends BaseController
{
    public function index(): View
    {
        $warehouses = Warehouse::withCount('products')->paginate(15);

        return view('shop::warehouses.index', compact('warehouses'));
    }

    public function create(): View
    {
        return view('shop::warehouses.create');
    }

    public function store(Request $request): RedirectResponse
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

        Warehouse::create($data);

        return redirect()->route('shop.warehouses.index')
            ->with('success', 'Склад добавлен.');
    }

    public function show(Warehouse $warehouse): View
    {
        $warehouse->load('products');

        return view('shop::warehouses.show', compact('warehouse'));
    }

    public function edit(Warehouse $warehouse): View
    {
        return view('shop::warehouses.edit', compact('warehouse'));
    }

    public function update(Request $request, Warehouse $warehouse): RedirectResponse
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

        return redirect()->route('shop.warehouses.index')
            ->with('success', 'Данные склада обновлены.');
    }

    public function destroy(Warehouse $warehouse): RedirectResponse
    {
        $warehouse->delete();

        return redirect()->route('shop.warehouses.index')
            ->with('success', 'Склад удалён.');
    }
}
