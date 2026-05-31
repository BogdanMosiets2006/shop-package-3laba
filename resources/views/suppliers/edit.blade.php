@extends('shop::layouts.app')
@section('title', 'Редактировать поставщика')
@section('content')
<h1 class="mb-4">Редактировать: {{ $supplier->name }}</h1>
<form method="POST" action="{{ route('shop.suppliers.update', $supplier) }}" class="col-md-7">
    @csrf @method('PUT')
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Название *</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $supplier->name) }}" required>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Email *</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email', $supplier->email) }}" required>
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Телефон</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $supplier->phone) }}">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Контактное лицо</label>
            <input type="text" name="contact_person" class="form-control" value="{{ old('contact_person', $supplier->contact_person) }}">
        </div>
        <div class="col-12 mb-3">
            <label class="form-label">Адрес</label>
            <input type="text" name="address" class="form-control" value="{{ old('address', $supplier->address) }}">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Город</label>
            <input type="text" name="city" class="form-control" value="{{ old('city', $supplier->city) }}">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Страна</label>
            <input type="text" name="country" class="form-control" value="{{ old('country', $supplier->country) }}">
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Обновить</button>
    <a href="{{ route('shop.suppliers.index') }}" class="btn btn-secondary ms-2">Отмена</a>
</form>
@endsection