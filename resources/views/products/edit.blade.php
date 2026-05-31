@extends('shop::layouts.app')
@section('title', 'Редактировать: ' . $product->name)
@section('content')
<h1 class="mb-4">Редактировать: {{ $product->name }}</h1>
<form method="POST" action="{{ route('shop.products.update', $product) }}">
    @csrf @method('PUT')
    <div class="row">
        <div class="col-md-8">
            <div class="mb-3">
                <label class="form-label">Название *</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $product->name) }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Slug *</label>
                <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror"
                       value="{{ old('slug', $product->slug) }}" required>
                @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Описание</label>
                <textarea name="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">SKU</label>
                <input type="text" name="sku" class="form-control @error('sku') is-invalid @enderror"
                       value="{{ old('sku', $product->sku) }}">
                @error('sku')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Цена *</label>
                <input type="number" step="0.01" min="0" name="price"
                       class="form-control @error('price') is-invalid @enderror"
                       value="{{ old('price', $product->price) }}" required>
                @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Вес (кг)</label>
                <input type="number" step="0.001" min="0" name="weight"
                       class="form-control" value="{{ old('weight', $product->weight) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Категория</label>
                <select name="category_id" class="form-select">
                    <option value="">— Без категории —</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}"
                            {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Поставщик</label>
                <select name="supplier_id" class="form-select">
                    <option value="">— Без поставщика —</option>
                    @foreach($suppliers as $sup)
                        <option value="{{ $sup->id }}"
                            {{ old('supplier_id', $product->supplier_id) == $sup->id ? 'selected' : '' }}>
                            {{ $sup->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" name="is_active" class="form-check-input"
                       value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                <label class="form-check-label">Активен</label>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Обновить</button>
    <a href="{{ route('shop.products.index') }}" class="btn btn-secondary ms-2">Отмена</a>
</form>
@endsection
