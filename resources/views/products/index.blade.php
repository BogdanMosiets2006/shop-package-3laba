@extends('shop::layouts.app')
@section('title', 'Товары')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Товары</h1>
    <a href="{{ route('shop.products.create') }}" class="btn btn-primary">+ Добавить товар</a>
</div>
<table class="table table-bordered table-hover">
    <thead class="table-dark">
        <tr>
            <th>#</th><th>Название</th><th>SKU</th>
            <th>Категория</th><th>Поставщик</th>
            <th>Цена</th><th>Активен</th><th>Действия</th>
        </tr>
    </thead>
    <tbody>
        @forelse($products as $product)
        <tr>
            <td>{{ $product->id }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->sku ?? '—' }}</td>
            <td>{{ $product->category?->name ?? '—' }}</td>
            <td>{{ $product->supplier?->name ?? '—' }}</td>
            <td>{{ number_format($product->price, 2) }}</td>
            <td>{{ $product->is_active ? '✓' : '✗' }}</td>
            <td>
                <a href="{{ route('shop.products.show', $product) }}" class="btn btn-sm btn-info">Просмотр</a>
                <a href="{{ route('shop.products.edit', $product) }}" class="btn btn-sm btn-warning">Изменить</a>
                <form action="{{ route('shop.products.destroy', $product) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Удалить товар?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Удалить</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="8" class="text-center text-muted">Нет товаров</td></tr>
        @endforelse
    </tbody>
</table>
{{ $products->links() }}
@endsection
