@extends('shop::layouts.app')
@section('title', 'Поставщики')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Поставщики</h1>
    <a href="{{ route('shop.suppliers.create') }}" class="btn btn-primary">+ Добавить поставщика</a>
</div>
<table class="table table-bordered table-hover">
    <thead class="table-dark">
        <tr><th>#</th><th>Название</th><th>Email</th><th>Город</th><th>Контакт</th><th>Товаров</th><th>Действия</th></tr>
    </thead>
    <tbody>
        @forelse($suppliers as $supplier)
        <tr>
            <td>{{ $supplier->id }}</td>
            <td>{{ $supplier->name }}</td>
            <td>{{ $supplier->email }}</td>
            <td>{{ $supplier->city ?? '—' }}</td>
            <td>{{ $supplier->contact_person ?? '—' }}</td>
            <td>{{ $supplier->products_count }}</td>
            <td>
                <a href="{{ route('shop.suppliers.show', $supplier) }}" class="btn btn-sm btn-info">Просмотр</a>
                <a href="{{ route('shop.suppliers.edit', $supplier) }}" class="btn btn-sm btn-warning">Изменить</a>
                <form action="{{ route('shop.suppliers.destroy', $supplier) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Удалить поставщика?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Удалить</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="7" class="text-center text-muted">Нет поставщиков</td></tr>
        @endforelse
    </tbody>
</table>
{{ $suppliers->links() }}
@endsection