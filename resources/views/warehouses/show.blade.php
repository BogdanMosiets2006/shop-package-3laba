@extends('shop::layouts.app')
@section('title', $warehouse->name)
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>{{ $warehouse->name }}</h1>
    <div>
        <a href="{{ route('shop.warehouses.edit', $warehouse) }}" class="btn btn-warning">Изменить</a>
        <a href="{{ route('shop.warehouses.index') }}" class="btn btn-secondary ms-2">К списку</a>
    </div>
</div>
<table class="table table-bordered w-50">
    <tr><th width="150">Адрес</th><td>{{ $warehouse->address }}</td></tr>
    <tr><th>Город</th><td>{{ $warehouse->city }}</td></tr>
    <tr><th>Страна</th><td>{{ $warehouse->country }}</td></tr>
    <tr><th>Координаты</th><td>{{ $warehouse->latitude ?? '—' }}, {{ $warehouse->longitude ?? '—' }}</td></tr>
    <tr><th>Менеджер</th><td>{{ $warehouse->manager_name ?? '—' }}</td></tr>
    <tr><th>Телефон</th><td>{{ $warehouse->phone ?? '—' }}</td></tr>
</table>
@if($warehouse->products->count())
<h5 class="mt-3">Товары на складе</h5>
<table class="table table-sm table-bordered">
    <thead><tr><th>Товар</th><th>Количество</th></tr></thead>
    <tbody>
        @foreach($warehouse->products as $p)
        <tr>
            <td><a href="{{ route('shop.products.show', $p) }}">{{ $p->name }}</a></td>
            <td>{{ $p->pivot->quantity }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
@endsection