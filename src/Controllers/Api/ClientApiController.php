<?php

namespace Vendor\ShopPackage\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Vendor\ShopPackage\Controllers\BaseController;
use Vendor\ShopPackage\Models\Client;

class ClientApiController extends BaseController
{
    public function index(): JsonResponse
    {
        return response()->json(Client::withCount('orders')->paginate(15));
    }

    public function store(Request $request): JsonResponse
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
        return response()->json(Client::create($data), 201);
    }

    public function show(Client $client): JsonResponse
    {
        return response()->json($client->load('orders'));
    }

    public function update(Request $request, Client $client): JsonResponse
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
        return response()->json($client);
    }

    public function destroy(Client $client): JsonResponse
    {
        $client->delete();
        return response()->json(['message' => 'Клиент удалён.']);
    }
}
