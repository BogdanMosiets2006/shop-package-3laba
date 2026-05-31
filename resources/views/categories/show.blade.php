@extends('shop::layouts.app')
@section('title', $category->name)
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>{{ $category->name }}</h1>
    <div>
        <a href="{{ route('shop.categories.edit', $category) }}" class="btn btn-warning">Изменить</a>
        <a href="{{ route('shop.categories.index') }}" class="btn btn-secondary ms-2">К списку</a>
    </div>
</div>
<table class="table table-bordered w-50">
    <tr><th width="150">ID</th><td>{{ $category->id }}</td></tr>
    <tr><th>Slug</th><td>{{ $category->slug }}</td></tr>
    <tr><th>Родитель</th><td>{{ $category->parent?->name ?? '—' }}</td></tr>
    <tr><th>Описание</th><td>{{ $category->description ?? '—' }}</td></tr>
</table>
@if($category->products->count())
<h5 class="mt-3">Товары категории</h5>
<ul>@foreach($category->products as $p)<li><a href="{{ route('shop.products.show', $p) }}">{{ $p->name }}</a></li>@endforeach</ul>
@endif
@endsection