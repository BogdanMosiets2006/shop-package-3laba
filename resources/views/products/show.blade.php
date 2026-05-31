@extends('shop::layouts.app')
@section('title', $product->name)
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>{{ $product->name }}</h1>
    <div>
        <a href="{{ route('shop.products.edit', $product) }}" class="btn btn-warning">Изменить</a>
        <a href="{{ route('shop.products.index') }}" class="btn btn-secondary ms-2">К списку</a>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <table class="table table-bordered">
            <tr><th width="150">ID</th><td>{{ $product->id }}</td></tr>
            <tr><th>Slug</th><td>{{ $product->slug }}</td></tr>
            <tr><th>SKU</th><td>{{ $product->sku ?? '—' }}</td></tr>
            <tr><th>Цена</th><td>{{ number_format($product->price, 2) }}</td></tr>
            <tr><th>Вес</th><td>{{ $product->weight ? $product->weight . ' кг' : '—' }}</td></tr>
            <tr><th>Категория</th><td>{{ $product->category?->name ?? '—' }}</td></tr>
            <tr><th>Поставщик</th><td>{{ $product->supplier?->name ?? '—' }}</td></tr>
            <tr><th>Активен</th><td>{{ $product->is_active ? 'Да' : 'Нет' }}</td></tr>
            <tr><th>Создан</th><td>{{ $product->created_at->format('d.m.Y H:i') }}</td></tr>
        </table>
    </div>
    <div class="col-md-6">
        <h5>Описание</h5>
        <p>{{ $product->description ?? 'Нет описания' }}</p>

        @if($product->warehouses->count())
        <h5 class="mt-3">Остатки на складах</h5>
        <table class="table table-sm table-bordered">
            <thead><tr><th>Склад</th><th>Количество</th></tr></thead>
            <tbody>
                @foreach($product->warehouses as $wh)
                <tr><td>{{ $wh->name }}</td><td>{{ $wh->pivot->quantity }}</td></tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
@endsection
