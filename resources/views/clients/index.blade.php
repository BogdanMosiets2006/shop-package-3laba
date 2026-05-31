@extends('shop::layouts.app')
@section('title', 'Клиенты')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Клиенты</h1>
    <a href="{{ route('shop.clients.create') }}" class="btn btn-primary">+ Добавить клиента</a>
</div>
<table class="table table-bordered table-hover">
    <thead class="table-dark">
        <tr><th>#</th><th>Имя</th><th>Email</th><th>Город</th><th>Заказов</th><th>Действия</th></tr>
    </thead>
    <tbody>
        @forelse($clients as $client)
        <tr>
            <td>{{ $client->id }}</td>
            <td>{{ $client->full_name }}</td>
            <td>{{ $client->email }}</td>
            <td>{{ $client->city ?? '—' }}</td>
            <td>{{ $client->orders_count }}</td>
            <td>
                <a href="{{ route('shop.clients.show', $client) }}" class="btn btn-sm btn-info">Просмотр</a>
                <a href="{{ route('shop.clients.edit', $client) }}" class="btn btn-sm btn-warning">Изменить</a>
                <form action="{{ route('shop.clients.destroy', $client) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Удалить клиента?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Удалить</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center text-muted">Нет клиентов</td></tr>
        @endforelse
    </tbody>
</table>
{{ $clients->links() }}
@endsection