@extends('shop::layouts.app')
@section('title', 'Редактировать клиента')
@section('content')
<h1 class="mb-4">Редактировать: {{ $client->full_name }}</h1>
<form method="POST" action="{{ route('shop.clients.update', $client) }}" class="col-md-7">
    @csrf @method('PUT')
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Имя *</label>
            <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror"
                   value="{{ old('first_name', $client->first_name) }}" required>
            @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Фамилия *</label>
            <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror"
                   value="{{ old('last_name', $client->last_name) }}" required>
            @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Email *</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email', $client->email) }}" required>
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Телефон</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $client->phone) }}">
        </div>
        <div class="col-12 mb-3">
            <label class="form-label">Адрес</label>
            <input type="text" name="address" class="form-control" value="{{ old('address', $client->address) }}">
        </div>
        <div class="col-md-5 mb-3">
            <label class="form-label">Город</label>
            <input type="text" name="city" class="form-control" value="{{ old('city', $client->city) }}">
        </div>
        <div class="col-md-5 mb-3">
            <label class="form-label">Страна</label>
            <input type="text" name="country" class="form-control" value="{{ old('country', $client->country) }}">
        </div>
        <div class="col-md-2 mb-3">
            <label class="form-label">Индекс</label>
            <input type="text" name="postal_code" class="form-control" value="{{ old('postal_code', $client->postal_code) }}">
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Обновить</button>
    <a href="{{ route('shop.clients.index') }}" class="btn btn-secondary ms-2">Отмена</a>
</form>
@endsection