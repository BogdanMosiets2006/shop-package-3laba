<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Интернет-магазин')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="#">Shop Admin</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="{{ route('shop.products.index') }}">Товары</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('shop.categories.index') }}">Категории</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('shop.suppliers.index') }}">Поставщики</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('shop.clients.index') }}">Клиенты</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('shop.warehouses.index') }}">Склады</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('shop.orders.index') }}">Заказы</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="container">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif
    @yield('content')
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
