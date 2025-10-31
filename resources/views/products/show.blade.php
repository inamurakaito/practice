@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">商品詳細</h1>

    <div class="mb-3">
        <strong class="me-2">ID：</strong> {{ $product->id }}
    </div>

    <div class="d-flex align-items-center mb-4">
        <strong class="me-3">商品画像：</strong>
        @if ($product->img_path)
            <img src="{{ asset('storage/' . $product->img_path) }}" alt="商品画像" style="max-width: 300px;">
        @else
            <span>画像は登録されていません。</span>
        @endif
    </div>

    <div class="mb-3">
        <strong class="me-2">商品名：</strong> {{ $product->product_name }}
    </div>

    <div class="mb-3">
        <strong class="me-2">価格：</strong> {{ $product->price }} 円
    </div>

    <div class="mb-3">
        <strong class="me-2">在庫：</strong> {{ $product->stock }}
    </div>

    <div class="d-flex align-items-center mb-4">
        <strong class="me-3">コメント：</strong>
        <span>{{ $product->comment ?? 'なし' }}</span>
    </div>

    <table class="table table-bordered mt-4">
        <tr>
            <th>登録日</th>
            <td>{{ $product->created_at }}</td>
        </tr>
        <tr>
            <th>更新日</th>
            <td>{{ $product->updated_at }}</td>
        </tr>
    </table>

    <div class="mt-4">
        <a href="{{ route('products.index') }}" class="btn btn-secondary me-2">戻る</a>
        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">編集</a>
    </div>
</div>
@endsection