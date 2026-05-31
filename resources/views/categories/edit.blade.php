@extends('shop::layouts.app')
@section('title', 'Редактировать категорию')
@section('content')
<h1 class="mb-4">Редактировать: {{ $category->name }}</h1>
<form method="POST" action="{{ route('shop.categories.update', $category) }}" class="col-md-6">
    @csrf @method('PUT')
    <div class="mb-3">
        <label class="form-label">Название *</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $category->name) }}" required>
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Slug *</label>
        <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror"
               value="{{ old('slug', $category->slug) }}" required>
        @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Описание</label>
        <textarea name="description" class="form-control" rows="3">{{ old('description', $category->description) }}</textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Родительская категория</label>
        <select name="parent_id" class="form-select">
            <option value="">— Корневая —</option>
            @foreach($parents as $parent)
                <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                    {{ $parent->name }}
                </option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Обновить</button>
    <a href="{{ route('shop.categories.index') }}" class="btn btn-secondary ms-2">Отмена</a>
</form>
@endsection