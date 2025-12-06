@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品一覧</h1>

    {{-- 検索フォーム --}}
    <form id="search-form" class="mb-3">
        <div class="row g-2">

            {{-- キーワード --}}
            <div class="col-md-3">
                <input type="text" name="keyword" class="form-control"
                    placeholder="検索キーワード" value="{{ request('keyword') }}">
            </div>

            {{-- メーカー --}}
            <div class="col-md-2">
                <select name="company_id" class="form-select">
                    <option value="">メーカーを選択</option>
                    @foreach($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- 価格（下限） --}}
            <div class="col-md-2">
                <input type="number" name="price_min" class="form-control"
                    placeholder="価格 下限">
            </div>

            {{-- 価格（上限） --}}
            <div class="col-md-2">
                <input type="number" name="price_max" class="form-control"
                    placeholder="価格 上限">
            </div>

            {{-- 在庫（下限） --}}
            <div class="col-md-2">
                <input type="number" name="stock_min" class="form-control"
                    placeholder="在庫 下限">
            </div>

            {{-- 在庫（上限） --}}
            <div class="col-md-2">
                <input type="number" name="stock_max" class="form-control"
                    placeholder="在庫 上限">
            </div>

            {{-- 検索ボタン --}}
            <div class="col-md-1">
                <button class="btn btn-outline-primary w-100">検索</button>
            </div>

        </div>
    </form>

    <a href="{{ route('products.create') }}" class="btn btn-success mb-3">＋ 新規登録</a>

    {{-- メッセージ --}}
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    {{-- 商品一覧 --}}
    <table class="table table-striped">
        <thead>
            <tr>
                <th>
                    <a class="sort-link" href="{{ route('products.index', array_merge(request()->query(), ['sort' => 'id', 'order' => request('order') === 'asc' ? 'desc' : 'asc'])) }}">
                        ID
                    </a>
                </th>
                <th>画像</th>
                <th>
                    <a class="sort-link" href="{{ route('products.index', array_merge(request()->query(), ['sort' => 'product_name', 'order' => request('order') === 'asc' ? 'desc' : 'asc'])) }}">
                        商品名
                    </a>
                </th>
                <th>
                    <a class="sort-link" href="{{ route('products.index', array_merge(request()->query(), ['sort' => 'price', 'order' => request('order') === 'asc' ? 'desc' : 'asc'])) }}">
                        価格
                    </a>
                </th>
                <th>
                    <a class="sort-link" href="{{ route('products.index', array_merge(request()->query(), ['sort' => 'stock', 'order' => request('order') === 'asc' ? 'desc' : 'asc'])) }}">
                        在庫数
                    </a>
                </th>
                <th>
                    <a class="sort-link" href="{{ route('products.index', array_merge(request()->query(), ['sort' => 'company_id', 'order' => request('order') === 'asc' ? 'desc' : 'asc'])) }}">
                        メーカー
                    </a>
                </th>
                <th>操作</th>
            </tr>
        </thead>

        {{-- Ajax で書き換える箇所 --}}
        <tbody id="product-table-body">
            @include('products.partials.list', ['products' => $products])
        </tbody>

    </table>
</div>
@endsection


{{-- ▼ ページ下に Ajax 処理を追加する --}}
@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // 検索フォーム送信イベントを Ajax 化
    $('#search-form').on('submit', function(e) {
        e.preventDefault(); // ページ遷移を防ぐ

        $.ajax({
            url: "{{ route('ajax.search') }}",
            type: "GET",
            data: $(this).serialize(), // フォームの入力内容を送信
            success: function(response) {
                $('#product-table-body').html(response.html); // 部分HTMLを差し替え
            },
            error: function() {
                alert('検索に失敗しました');
            }
        });
    });

    // ▼ Ajax削除処理
    $(document).on('click', '.delete-btn', function(e) {
        e.preventDefault();

        if (!confirm('本当に削除しますか？')) return;

        let id = $(this).data('id');

        $.ajax({
            url: `/products/${id}`,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    $(`#product-${id}`).remove();
                } else {
                    alert('削除に失敗しました');
                }
            },
            error: function() {
                alert('通信エラーが発生しました');
            }
        });
    });

    // ▼ Ajaxソート処理
    $(document).on('click', '.sort-link', function(e) {
        e.preventDefault();

        let url = $(this).attr('href');

        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                $('#product-table-body').html(response.html);
            },
            error: function() {
                alert('ソートに失敗しました');
            }
        });
    });

    // ▼ Ajax購入処理
    $(document).on('click', '.purchase-btn', function(e) {
        e.preventDefault();

        let id = $(this).data('id');

        if (!confirm('この商品を購入しますか？')) return;

        $.ajax({
            url: "/api/purchase",
            type: "POST",
            data: {
                product_id: id
            },
            success: function(response) {
                alert(response.message);

                // 在庫数の表示を更新
                let stockCell = $(`#product-${id}`).find('td').eq(4);
                stockCell.text(response.stock_after);
            },
            error: function(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    alert("エラー: " + xhr.responseJSON.message);
                } else {
                    alert("購入処理に失敗しました");
                }
            }
        });
    });
</script>
@endsection