@extends('shop::layouts.app')
@section('title', 'Заказ #' . $order->id)
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Заказ #{{ $order->id }}</h1>
    <div>
        <a href="{{ route('shop.orders.edit', $order) }}" class="btn btn-warning">Изменить</a>
        <a href="{{ route('shop.orders.index') }}" class="btn btn-secondary ms-2">К списку</a>
    </div>
</div>
<div class="row">
    <div class="col-md-5">
        <table class="table table-bordered">
            <tr><th width="150">Клиент</th><td>{{ $order->client?->full_name ?? '—' }}</td></tr>
            <tr><th>Статус</th><td><span class="badge bg-secondary">{{ $order->status }}</span></td></tr>
            <tr><th>Сумма</th><td><strong>{{ number_format($order->total_price, 2) }}</strong></td></tr>
            <tr><th>Адрес</th><td>{{ $order->delivery_address ?? '—' }}</td></tr>
            <tr><th>Город</th><td>{{ $order->delivery_city ?? '—' }}</td></tr>
            <tr><th>Страна</th><td>{{ $order->delivery_country ?? '—' }}</td></tr>
            <tr><th>Примечание</th><td>{{ $order->notes ?? '—' }}</td></tr>
            <tr><th>Дата</th><td>{{ $order->created_at->format('d.m.Y H:i') }}</td></tr>
        </table>
    </div>
    <div class="col-md-7">
        <h5>Состав заказа</h5>
        <table class="table table-bordered">
            <thead><tr><th>Товар</th><th>Цена</th><th>Кол-во</th><th>Итого</th></tr></thead>
            <tbody>
                @foreach($order->products as $p)
                <tr>
                    <td>{{ $p->name }}</td>
                    <td>{{ number_format($p->pivot->price, 2) }}</td>
                    <td>{{ $p->pivot->quantity }}</td>
                    <td>{{ number_format($p->pivot->price * $p->pivot->quantity, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr><td colspan="3" class="text-end"><strong>Итого:</strong></td>
                    <td><strong>{{ number_format($order->total_price, 2) }}</strong></td></tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection