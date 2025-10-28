@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品一覧</h1>

    <a href="{{ route('products.create') }}" class="btn btn-success mb-3">＋ 新規登録</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>商品名</th>
                <th>メーカー</th>
                <th>価格</th>
                <th>在庫数</th>
                <th>コメント</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->company->company_name ?? '不明' }}</td>
                    <td>{{ $product->price }}円</td>
                    <td>{{ $product->stock }}</td>
                    <td>{{ $product->comment }}</td>
                    <td>
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm">詳細</a>
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary btn-sm">編集</a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('削除してよろしいですか？')">削除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
</div>
@endsection