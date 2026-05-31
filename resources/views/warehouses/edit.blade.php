@extends('shop::layouts.app')
@section('title', 'Редактировать склад')
@section('content')
<h1 class="mb-4">Редактировать: {{ $warehouse->name }}</h1>
<form method="POST" action="{{ route('shop.warehouses.update', $warehouse) }}" class="col-md-7">
    @csrf @method('PUT')
    <div class="row">
        <div class="col-12 mb-3">
            <label class="form-label">Название *</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $warehouse->name) }}" required>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-12 mb-3">
            <label class="form-label">Адрес *</label>
            <input type="text" name="address" class="form-control" value="{{ old('address', $warehouse->address) }}" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Город *</label>
            <input type="text" name="city" class="form-control" value="{{ old('city', $warehouse->city) }}" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Страна *</label>
            <input type="text" name="country" class="form-control" value="{{ old('country', $warehouse->country) }}" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Широта</label>
            <input type="number" step="0.0000001" name="latitude" class="form-control" value="{{ old('latitude', $warehouse->latitude) }}">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Долгота</label>
            <input type="number" step="0.0000001" name="longitude" class="form-control" value="{{ old('longitude', $warehouse->longitude) }}">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Менеджер</label>
            <input type="text" name="manager_name" class="form-control" value="{{ old('manager_name', $warehouse->manager_name) }}">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Телефон</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $warehouse->phone) }}">
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Обновить</button>
    <a href="{{ route('shop.warehouses.index') }}" class="btn btn-secondary ms-2">Отмена</a>
</form>
@endsection