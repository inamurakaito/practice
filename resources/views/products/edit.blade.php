@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">商品編集フォーム</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        <div class="d-flex align-items-center mb-3">
            <label class="form-label me-3" style="width: 120px;">ID</label>
            <p class="mb-0">{{ $product->id }}</p>
        </div>
        @csrf
        @method('PUT')

        <div class="d-flex align-items-center mb-3">
            <label for="product_name" class="form-label me-3" style="width: 120px;">商品名</label>
            <input type="text" name="product_name" class="form-control w-50" value="{{ old('product_name', $product->product_name) }}">
        </div>

        <div class="d-flex align-items-center mb-3">
            <label for="company_id" class="form-label me-3" style="width: 120px;">メーカー</label>
            <select name="company_id" class="form-control w-50">
                @foreach($companies as $company)
                <option value="{{ $company->id }}" {{ $product->company_id == $company->id ? 'selected' : '' }}>
                    {{ $company->company_name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="d-flex align-items-center mb-3">
            <label for="price" class="form-label me-3" style="width: 120px;">価格</label>
            <input type="number" name="price" class="form-control w-50" value="{{ old('price', $product->price) }}">
        </div>

        <div class="d-flex align-items-center mb-3">
            <label for="stock" class="form-label me-3" style="width: 120px;">在庫数</label>
            <input type="number" name="stock" class="form-control w-50" value="{{ old('stock', $product->stock) }}">
        </div>

        <div class="d-flex align-items-center mb-3">
            <label for="comment" class="form-label me-3" style="width: 120px;">コメント</label>
            <textarea name="comment" class="form-control w-50" rows="2">{{ old('comment', $product->comment) }}</textarea>
        </div>

        <div class="d-flex align-items-center mb-4">
            <label for="image" class="form-label me-3" style="width: 120px;">商品画像</label>
            <input type="file" name="image" class="form-control w-50">
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary me-2">更新する</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">戻る</a>
        </div>
    </form>
</div>
@endsection