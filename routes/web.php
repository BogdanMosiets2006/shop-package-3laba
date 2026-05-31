<?php

use Illuminate\Support\Facades\Route;
use Vendor\ShopPackage\Controllers\CategoryController;
use Vendor\ShopPackage\Controllers\ClientController;
use Vendor\ShopPackage\Controllers\OrderController;
use Vendor\ShopPackage\Controllers\ProductController;
use Vendor\ShopPackage\Controllers\SupplierController;
use Vendor\ShopPackage\Controllers\WarehouseController;

Route::resource('products',   ProductController::class)->names([
    'index'   => 'shop.products.index',
    'create'  => 'shop.products.create',
    'store'   => 'shop.products.store',
    'show'    => 'shop.products.show',
    'edit'    => 'shop.products.edit',
    'update'  => 'shop.products.update',
    'destroy' => 'shop.products.destroy',
]);

Route::resource('categories', CategoryController::class)->names([
    'index'   => 'shop.categories.index',
    'create'  => 'shop.categories.create',
    'store'   => 'shop.categories.store',
    'show'    => 'shop.categories.show',
    'edit'    => 'shop.categories.edit',
    'update'  => 'shop.categories.update',
    'destroy' => 'shop.categories.destroy',
]);

Route::resource('suppliers',  SupplierController::class)->names([
    'index'   => 'shop.suppliers.index',
    'create'  => 'shop.suppliers.create',
    'store'   => 'shop.suppliers.store',
    'show'    => 'shop.suppliers.show',
    'edit'    => 'shop.suppliers.edit',
    'update'  => 'shop.suppliers.update',
    'destroy' => 'shop.suppliers.destroy',
]);

Route::resource('clients',    ClientController::class)->names([
    'index'   => 'shop.clients.index',
    'create'  => 'shop.clients.create',
    'store'   => 'shop.clients.store',
    'show'    => 'shop.clients.show',
    'edit'    => 'shop.clients.edit',
    'update'  => 'shop.clients.update',
    'destroy' => 'shop.clients.destroy',
]);

Route::resource('warehouses', WarehouseController::class)->names([
    'index'   => 'shop.warehouses.index',
    'create'  => 'shop.warehouses.create',
    'store'   => 'shop.warehouses.store',
    'show'    => 'shop.warehouses.show',
    'edit'    => 'shop.warehouses.edit',
    'update'  => 'shop.warehouses.update',
    'destroy' => 'shop.warehouses.destroy',
]);

Route::resource('orders',     OrderController::class)->names([
    'index'   => 'shop.orders.index',
    'create'  => 'shop.orders.create',
    'store'   => 'shop.orders.store',
    'show'    => 'shop.orders.show',
    'edit'    => 'shop.orders.edit',
    'update'  => 'shop.orders.update',
    'destroy' => 'shop.orders.destroy',
]);
