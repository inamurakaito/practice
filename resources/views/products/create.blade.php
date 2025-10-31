@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">商品登録フォーム</h1>

    {{-- エラーメッセージ表示 --}}
    @if ($errors->any())
        <div class="alert alert-danger w-50 mx-auto">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="w-50 mx-auto">
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
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

            <div class="form-group mb-3 d-flex align-items-center">
                <label for="comment" class="me-3 mb-0" style="width: 20%;">コメント（任意）</label>
                <textarea name="comment" class="form-control" rows="3" style="width: 80%;">{{ old('comment') }}</textarea>
            </div>

            <div class="form-group mb-4 d-flex align-items-center">
                <label for="image" class="me-3 mb-0" style="width: 20%;">商品画像</label>
                <input type="file" name="image" class="form-control" style="width: 80%;">
            </div>

            <div class="d-flex justify-content-center mt-4">
                <button type="submit" class="btn btn-warning me-3 px-4">新規登録</button>
                <a href="{{ route('products.index') }}" class="btn btn-info px-4">戻る</a>
            </div>
        </form>
    </div>
</div>
@endsection