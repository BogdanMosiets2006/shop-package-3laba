@extends('shop::layouts.app')
@section('title', 'Добавить склад')
@section('content')
<h1 class="mb-4">Добавить склад</h1>
<form method="POST" action="{{ route('shop.warehouses.store') }}" class="col-md-7">
    @csrf
    <div class="row">
        <div class="col-12 mb-3">
            <label class="form-label">Название *</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name') }}" required>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-12 mb-3">
            <label class="form-label">Адрес *</label>
            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                   value="{{ old('address') }}" required>
            @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Город *</label>
            <input type="text" name="city" class="form-control @error('city') is-invalid @enderror"
                   value="{{ old('city') }}" required>
            @error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Страна *</label>
            <input type="text" name="country" class="form-control @error('country') is-invalid @enderror"
                   value="{{ old('country') }}" required>
            @error('country')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Широта</label>
            <input type="number" step="0.0000001" name="latitude" class="form-control" value="{{ old('latitude') }}">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Долгота</label>
            <input type="number" step="0.0000001" name="longitude" class="form-control" value="{{ old('longitude') }}">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Менеджер</label>
            <input type="text" name="manager_name" class="form-control" value="{{ old('manager_name') }}">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Телефон</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Сохранить</button>
    <a href="{{ route('shop.warehouses.index') }}" class="btn btn-secondary ms-2">Отмена</a>
</form>
@endsection