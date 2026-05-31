@extends('shop::layouts.app')
@section('title', 'Категории')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Категории</h1>
    <a href="{{ route('shop.categories.create') }}" class="btn btn-primary">+ Добавить категорию</a>
</div>
<table class="table table-bordered table-hover">
    <thead class="table-dark">
        <tr><th>#</th><th>Название</th><th>Родитель</th><th>Товаров</th><th>Действия</th></tr>
    </thead>
    <tbody>
        @forelse($categories as $category)
        <tr>
            <td>{{ $category->id }}</td>
            <td>{{ $category->name }}</td>
            <td>{{ $category->parent?->name ?? '—' }}</td>
            <td>{{ $category->products_count }}</td>
            <td>
                <a href="{{ route('shop.categories.show', $category) }}" class="btn btn-sm btn-info">Просмотр</a>
                <a href="{{ route('shop.categories.edit', $category) }}" class="btn btn-sm btn-warning">Изменить</a>
                <form action="{{ route('shop.categories.destroy', $category) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Удалить категорию?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Удалить</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="5" class="text-center text-muted">Нет категорий</td></tr>
        @endforelse
    </tbody>
</table>
{{ $categories->links() }}
@endsection