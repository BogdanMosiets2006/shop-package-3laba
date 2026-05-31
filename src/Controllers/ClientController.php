<?php

namespace Vendor\ShopPackage\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Vendor\ShopPackage\Models\Client;

class ClientController extends BaseController
{
    public function index(): View
    {
        $clients = Client::withCount('orders')->paginate(15);

        return view('shop::clients.index', compact('clients'));
    }

    public function create(): View
    {
        return view('shop::clients.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'first_name'  => 'required|string|max:100',
            'last_name'   => 'required|string|max:100',
            'email'       => 'required|email|unique:shop_clients,email',
            'phone'       => 'nullable|string|max:30',
            'address'     => 'nullable|string|max:255',
            'city'        => 'nullable|string|max:100',
            'country'     => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
        ]);

        Client::create($data);

        return redirect()->route('shop.clients.index')
            ->with('success', 'Клиент добавлен.');
    }

    public function show(Client $client): View
    {
        $client->load('orders');

        return view('shop::clients.show', compact('client'));
    }

    public function edit(Client $client): View
    {
        return view('shop::clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client): RedirectResponse
    {
        $data = $request->validate([
            'first_name'  => 'required|string|max:100',
            'last_name'   => 'required|string|max:100',
            'email'       => 'required|email|unique:shop_clients,email,' . $client->id,
            'phone'       => 'nullable|string|max:30',
            'address'     => 'nullable|string|max:255',
            'city'        => 'nullable|string|max:100',
            'country'     => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
        ]);

        $client->update($data);

        return redirect()->route('shop.clients.index')
            ->with('success', 'Данные клиента обновлены.');
    }

    public function destroy(Client $client): RedirectResponse
    {
        $client->delete();

        return redirect()->route('shop.clients.index')
            ->with('success', 'Клиент удалён.');
    }
}
