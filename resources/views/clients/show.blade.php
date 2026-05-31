@extends('shop::layouts.app')
@section('title', $client->full_name)
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>{{ $client->full_name }}</h1>
    <div>
        <a href="{{ route('shop.clients.edit', $client) }}" class="btn btn-warning">Изменить</a>
        <a href="{{ route('shop.clients.index') }}" class="btn btn-secondary ms-2">К списку</a>
    </div>
</div>
<table class="table table-bordered w-50">
    <tr><th width="150">Email</th><td>{{ $client->email }}</td></tr>
    <tr><th>Телефон</th><td>{{ $client->phone ?? '—' }}</td></tr>
    <tr><th>Адрес</th><td>{{ $client->address ?? '—' }}</td></tr>
    <tr><th>Город</th><td>{{ $client->city ?? '—' }}</td></tr>
    <tr><th>Страна</th><td>{{ $client->country ?? '—' }}</td></tr>
    <tr><th>Индекс</th><td>{{ $client->postal_code ?? '—' }}</td></tr>
</table>
@if($client->orders->count())
<h5 class="mt-3">Заказы клиента</h5>
<table class="table table-sm table-bordered">
    <thead><tr><th>#</th><th>Статус</th><th>Сумма</th><th>Дата</th></tr></thead>
    <tbody>
        @foreach($client->orders as $order)
        <tr>
            <td><a href="{{ route('shop.orders.show', $order) }}">{{ $order->id }}</a></td>
            <td>{{ $order->status }}</td>
            <td>{{ number_format($order->total_price, 2) }}</td>
            <td>{{ $order->created_at->format('d.m.Y') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
@endsection