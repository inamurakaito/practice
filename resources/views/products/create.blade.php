@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品登録フォーム</h1>

    {{-- エラーメッセージ表示 --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="product_name">商品名</label>
            <input type="text" name="product_name" class="form-control" value="{{ old('product_name') }}">
        </div>

        <div class="form-group mb-3">
            <label for="company_id">メーカー</label>
            <select name="company_id" class="form-control">
                <option value="">選択してください</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="price">価格</label>
            <input type="number" name="price" class="form-control" value="{{ old('price') }}">
        </div>

        <div class="form-group mb-3">
            <label for="stock">在庫数</label>
            <input type="number" name="stock" class="form-control" value="{{ old('stock') }}">
        </div>

        <div class="form-group mb-3">
            <label for="comment">コメント（任意）</label>
            <textarea name="comment" class="form-control" rows="3">{{ old('comment') }}</textarea>
        </div>

        <div class="form-group mb-3">
            <label for="image">商品画像</label>
            <input type="file" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">登録する</button>
    </form>
</div>
@endsection