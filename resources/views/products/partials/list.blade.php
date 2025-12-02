@foreach ($products as $product)
<tr id="product-{{ $product->id }}">
    <td>{{ $product->id }}</td>
    <td><img src="{{ asset('storage/' . $product->img_path) }}" width="80"></td>
    <td>{{ $product->product_name }}</td>
    <td>{{ $product->price }}</td>
    <td>{{ $product->stock }}</td>
    <td>{{ $product->company->company_name }}</td>
    <td>
        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary btn-sm">編集</a>

        <button class="btn btn-success btn-sm purchase-btn"
                data-id="{{ $product->id }}">
            購入
        </button>

        <button class="btn btn-danger btn-sm delete-btn"
                data-id="{{ $product->id }}">
            削除
        </button>
    </td>
</tr>
@endforeach