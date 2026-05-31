@extends('shop::layouts.app')
@section('title', 'Заказы')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Заказы</h1>
    <a href="{{ route('shop.orders.create') }}" class="btn btn-primary">+ Создать заказ</a>
</div>
<table class="table table-bordered table-hover">
    <thead class="table-dark">
        <tr><th>#</th><th>Клиент</th><th>Статус</th><th>Сумма</th><th>Город доставки</th><th>Дата</th><th>Действия</th></tr>
    </thead>
    <tbody>
        @forelse($orders as $order)
        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->client?->full_name ?? '—' }}</td>
            <td><span class="badge bg-secondary">{{ $order->status }}</span></td>
            <td>{{ number_format($order->total_price, 2) }}</td>
            <td>{{ $order->delivery_city ?? '—' }}</td>
            <td>{{ $order->created_at->format('d.m.Y') }}</td>
            <td>
                <a href="{{ route('shop.orders.show', $order) }}" class="btn btn-sm btn-info">Просмотр</a>
                <a href="{{ route('shop.orders.edit', $order) }}" class="btn btn-sm btn-warning">Изменить</a>
                <form action="{{ route('shop.orders.destroy', $order) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Удалить заказ?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Удалить</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="7" class="text-center text-muted">Нет заказов</td></tr>
        @endforelse
    </tbody>
</table>
{{ $orders->links() }}
@endsection