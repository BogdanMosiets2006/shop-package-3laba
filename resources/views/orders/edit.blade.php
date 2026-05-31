@extends('shop::layouts.app')
@section('title', 'Редактировать заказ #' . $order->id)
@section('content')
<h1 class="mb-4">Редактировать заказ #{{ $order->id }}</h1>
<form method="POST" action="{{ route('shop.orders.update', $order) }}" class="col-md-7">
    @csrf @method('PUT')
    <div class="mb-3">
        <label class="form-label">Клиент *</label>
        <select name="client_id" class="form-select" required>
            @foreach($clients as $client)
                <option value="{{ $client->id }}" {{ old('client_id', $order->client_id) == $client->id ? 'selected' : '' }}>
                    {{ $client->full_name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Статус *</label>
        <select name="status" class="form-select" required>
            @foreach(['pending','confirmed','shipped','delivered','cancelled'] as $s)
                <option value="{{ $s }}" {{ old('status', $order->status) === $s ? 'selected' : '' }}>{{ $s }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Адрес доставки</label>
        <input type="text" name="delivery_address" class="form-control" value="{{ old('delivery_address', $order->delivery_address) }}">
    </div>
    <div class="row">
        <div class="col mb-3">
            <label class="form-label">Город</label>
            <input type="text" name="delivery_city" class="form-control" value="{{ old('delivery_city', $order->delivery_city) }}">
        </div>
        <div class="col mb-3">
            <label class="form-label">Страна</label>
            <input type="text" name="delivery_country" class="form-control" value="{{ old('delivery_country', $order->delivery_country) }}">
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">Примечание</label>
        <textarea name="notes" class="form-control" rows="2">{{ old('notes', $order->notes) }}</textarea>
    </div>
    <button type="submit" class="btn btn-primary">Обновить</button>
    <a href="{{ route('shop.orders.index') }}" class="btn btn-secondary ms-2">Отмена</a>
</form>
@endsection