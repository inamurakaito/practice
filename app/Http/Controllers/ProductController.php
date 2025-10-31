<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{
    // 商品一覧表示
    public function index(Request $request)
    {
        $query = Product::with('company');

        // 商品名キーワード検索
        if ($request->filled('keyword')) {
            $query->where('product_name', 'like', '%' . $request->keyword . '%');
        }

        // メーカー絞り込み
        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        $products = $query->get();
        $companies = Company::all();

        return view('products.index', compact('products', 'companies'));
    }

    // 新規作成フォーム表示
    public function create()
    {
        $companies = Company::all();
        return view('products.create', compact('companies'));
    }

// 商品登録処理
public function store(Request $request)
{
    $request->validate([
        'product_name' => 'required|string|max:255',
        'company_id' => 'required|exists:companies,id',
        'price' => 'required|integer|min:0',
        'stock' => 'required|integer|min:0',
        'comment' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
    ]);

    try {
        $data = $request->all();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['img_path'] = $path;
        }

        Product::create($data);
        return Redirect::route('products.index')->with('success', '商品を登録しました！');
    } catch (\Exception $e) {
        return back()->withErrors(['error' => '登録に失敗しました: ' . $e->getMessage()]);
    }
}

    // 詳細表示（未実装）
    public function show($id)
    {
        $product = Product::with('company')->findOrFail($id);
        return view('products.show', compact('product'));
    }

    // 編集画面表示（未実装）
    public function edit($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $companies = \App\Models\Company::all();
        return view('products.edit', compact('product', 'companies'));
    }

    // 更新処理（未実装）
    public function update(Request $request, $id)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'comment' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
    ]);

    $product = Product::findOrFail($id);
    $data = $request->all();

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('products', 'public');
        $data['img_path'] = $path;
    }

    $product->update($data);
    return Redirect::route('products.index')->with('success', '商品情報を更新しました！');
    }

    // 削除処理（未実装）
    public function destroy($id)
    {
            $product = Product::findOrFail($id);
            $product->delete();

            return Redirect::route('products.index')->with('success', '商品を削除しました！');
    }
}
