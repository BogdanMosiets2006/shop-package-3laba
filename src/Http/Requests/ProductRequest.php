<?php

namespace Vendor\ShopPackage\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('product')?->id;

        return [
            'name'        => 'required|string|max:255',
            'slug'        => 'required|string|unique:shop_products,slug,' . $id,
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'weight'      => 'nullable|numeric|min:0',
            'sku'         => 'nullable|string|unique:shop_products,sku,' . $id,
            'is_active'   => 'boolean',
            'category_id' => 'nullable|exists:shop_categories,id',
            'supplier_id' => 'nullable|exists:shop_suppliers,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'  => 'Название товара обязательно.',
            'price.required' => 'Цена товара обязательна.',
            'price.numeric'  => 'Цена должна быть числом.',
            'slug.unique'    => 'Такой slug уже занят.',
        ];
    }
}
