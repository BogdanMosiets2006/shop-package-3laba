@extends('shop::layouts.app')
@section('title', 'Создать заказ')
@section('content')
<h1 class="mb-4">Создать заказ</h1>
<form method="POST" action="{{ route('shop.orders.store') }}">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Клиент *</label>
                <select name="client_id" class="form-select @error('client_id') is-invalid @enderror" required>
                    <option value="">— Выбрать клиента —</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                            {{ $client->full_name }} ({{ $client->email }})
                        </option>
                    @endforeach
                </select>
                @error('client_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Адрес доставки</label>
                <input type="text" name="delivery_address" class="form-control" value="{{ old('delivery_address') }}">
            </div>
            <div class="row">
                <div class="col mb-3">
                    <label class="form-label">Город</label>
                    <input type="text" name="delivery_city" class="form-control" value="{{ old('delivery_city') }}">
                </div>
                <div class="col mb-3">
                    <label class="form-label">Страна</label>
                    <input type="text" name="delivery_country" class="form-control" value="{{ old('delivery_country') }}">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Примечание</label>
                <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label">Товары *</label>
            <div id="products-list">
                <div class="input-group mb-2">
                    <select name="products[0][id]" class="form-select">
                        <option value="">— Выбрать товар —</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->price }})</option>
                        @endforeach
                    </select>
                    <input type="number" name="products[0][qty]" class="form-control" placeholder="Кол-во" min="1" value="1" style="max-width:90px">
                </div>
            </div>
            <button type="button" class="btn btn-outline-secondary btn-sm mb-3" onclick="addProductRow()">+ Добавить строку</button>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Создать заказ</button>
    <a href="{{ route('shop.orders.index') }}" class="btn btn-secondary ms-2">Отмена</a>
</form>
<script>
let idx = 1;
const productOptions = `@foreach($products as $p)<option value="{{ $p->id }}">{{ $p->name }} ({{ $p->price }})</option>@endforeach`;
function addProductRow() {
    const div = document.createElement('div');
    div.className = 'input-group mb-2';
    div.innerHTML = `<select name="products[${idx}][id]" class="form-select"><option value="">— Выбрать товар —</option>${productOptions}</select><input type="number" name="products[${idx}][qty]" class="form-control" placeholder="Кол-во" min="1" value="1" style="max-width:90px"><button type="button" class="btn btn-outline-danger" onclick="this.closest('.input-group').remove()">✕</button>`;
    document.getElementById('products-list').appendChild(div);
    idx++;
}
</script>
@endsection