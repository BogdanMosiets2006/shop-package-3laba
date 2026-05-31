@extends('shop::layouts.app')
@section('title', 'Склады')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Склады</h1>
    <a href="{{ route('shop.warehouses.create') }}" class="btn btn-primary">+ Добавить склад</a>
</div>
<table class="table table-bordered table-hover">
    <thead class="table-dark">
        <tr><th>#</th><th>Название</th><th>Город</th><th>Страна</th><th>Менеджер</th><th>Товаров</th><th>Действия</th></tr>
    </thead>
    <tbody>
        @forelse($warehouses as $warehouse)
        <tr>
            <td>{{ $warehouse->id }}</td>
            <td>{{ $warehouse->name }}</td>
            <td>{{ $warehouse->city }}</td>
            <td>{{ $warehouse->country }}</td>
            <td>{{ $warehouse->manager_name ?? '—' }}</td>
            <td>{{ $warehouse->products_count }}</td>
            <td>
                <a href="{{ route('shop.warehouses.show', $warehouse) }}" class="btn btn-sm btn-info">Просмотр</a>
                <a href="{{ route('shop.warehouses.edit', $warehouse) }}" class="btn btn-sm btn-warning">Изменить</a>
                <form action="{{ route('shop.warehouses.destroy', $warehouse) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Удалить склад?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Удалить</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="7" class="text-center text-muted">Нет складов</td></tr>
        @endforelse
    </tbody>
</table>
{{ $warehouses->links() }}
@endsection