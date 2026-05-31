@extends('shop::layouts.app')
@section('title', $supplier->name)
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>{{ $supplier->name }}</h1>
    <div>
        <a href="{{ route('shop.suppliers.edit', $supplier) }}" class="btn btn-warning">Изменить</a>
        <a href="{{ route('shop.suppliers.index') }}" class="btn btn-secondary ms-2">К списку</a>
    </div>
</div>
<table class="table table-bordered w-50">
    <tr><th width="160">Email</th><td>{{ $supplier->email }}</td></tr>
    <tr><th>Телефон</th><td>{{ $supplier->phone ?? '—' }}</td></tr>
    <tr><th>Адрес</th><td>{{ $supplier->address ?? '—' }}</td></tr>
    <tr><th>Город</th><td>{{ $supplier->city ?? '—' }}</td></tr>
    <tr><th>Страна</th><td>{{ $supplier->country ?? '—' }}</td></tr>
    <tr><th>Контактное лицо</th><td>{{ $supplier->contact_person ?? '—' }}</td></tr>
</table>
@endsection