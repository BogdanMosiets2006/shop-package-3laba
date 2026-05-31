<?php

namespace Vendor\ShopPackage\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Vendor\ShopPackage\Models\Supplier;

class SupplierController extends BaseController
{
    public function index(): View
    {
        $suppliers = Supplier::withCount('products')->paginate(15);

        return view('shop::suppliers.index', compact('suppliers'));
    }

    public function create(): View
    {
        return view('shop::suppliers.create');
    }

    public function store(Request $request): RedirectResponse
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

        Supplier::create($data);

        return redirect()->route('shop.suppliers.index')
            ->with('success', 'Поставщик добавлен.');
    }

    public function show(Supplier $supplier): View
    {
        $supplier->load('products');

        return view('shop::suppliers.show', compact('supplier'));
    }

    public function edit(Supplier $supplier): View
    {
        return view('shop::suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier): RedirectResponse
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

        return redirect()->route('shop.suppliers.index')
            ->with('success', 'Поставщик обновлён.');
    }

    public function destroy(Supplier $supplier): RedirectResponse
    {
        $supplier->delete();

        return redirect()->route('shop.suppliers.index')
            ->with('success', 'Поставщик удалён.');
    }
}
