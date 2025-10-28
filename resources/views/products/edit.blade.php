@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品編集フォーム</h1>

    <form action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="product_name">商品名</label>
            <input type="text" name="product_name" class="form-control" value="{{ old('product_name', $product->product_name) }}">
        </div>

        <div class="form-group mb-3">
            <label for="company_id">メーカー</label>
            <select name="company_id" class="form-control">
                @foreach($companies as $company)
                    <option value="{{ $company->id }}" {{ $product->company_id == $company->id ? 'selected' : '' }}>
                        {{ $company->company_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="price">価格</label>
            <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}">
        </div>

        <div class="form-group mb-3">
            <label for="stock">在庫数</label>
            <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}">
        </div>

        <div class="form-group mb-3">
            <label for="comment">コメント</label>
            <textarea name="comment" class="form-control">{{ old('comment', $product->comment) }}</textarea>
        </div>.     

        <div class="form-group mb-3">
            <label for="image">商品画像</label>
            <input type="file" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">更新する</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">戻る</a>
    </form>
</div>
@endsection