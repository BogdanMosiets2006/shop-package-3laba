<?php

use Illuminate\Support\Facades\Route;
use Vendor\ShopPackage\Controllers\Api\ProductApiController;
use Vendor\ShopPackage\Controllers\Api\CategoryApiController;
use Vendor\ShopPackage\Controllers\Api\SupplierApiController;
use Vendor\ShopPackage\Controllers\Api\ClientApiController;
use Vendor\ShopPackage\Controllers\Api\WarehouseApiController;
use Vendor\ShopPackage\Controllers\Api\OrderApiController;
use Vendor\ShopPackage\Http\Middleware\CheckApiVersion;

Route::middleware(CheckApiVersion::class)->group(function () {
    Route::apiResource('products',   ProductApiController::class);
    Route::apiResource('categories', CategoryApiController::class);
    Route::apiResource('suppliers',  SupplierApiController::class);
    Route::apiResource('clients',    ClientApiController::class);
    Route::apiResource('warehouses', WarehouseApiController::class);
    Route::apiResource('orders',     OrderApiController::class);
});
