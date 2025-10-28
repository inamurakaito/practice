@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品詳細</h1>

    <table class="table table-bordered">
        <p><strong>ID：</strong> {{ $product->id }}</p>

        @if ($product->img_path)
        <div class="mb-3">
            <label>商品画像</label><br>
            <img src="{{ asset('storage/' . $product->img_path) }}" alt="商品画像" style="max-width: 300px;">
        </div>
        @else
        <p>画像は登録されていません。</p>
        @endif

        <p><strong>商品名：</strong> {{ $product->product_name }}</p>
        <p><strong>価格：</strong> {{ $product->price }} 円</p>
        <p><strong>在庫：</strong> {{ $product->stock }}</p>
        <p><strong>コメント：</strong> {{ $product->comment }}</p>
        <tr>
            <th>登録日</th>
            <td>{{ $product->created_at }}</td>
        </tr>
        <tr>
            <th>更新日</th>
            <td>{{ $product->updated_at }}</td>
        </tr>
    </table>

    <a href="{{ route('products.index') }}" class="btn btn-secondary">戻る</a>
    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">編集</a>
</div>
@endsection