<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{
    // 商品一覧表示
    public function index()
    {
        $products = Product::with('company')->get();
        return view('products.index', compact('products'));
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
    ]);

    try {
        Product::create($request->all());
        return \Illuminate\Support\Facades\Redirect::route('products.index')->with('success', '商品を登録しました！');
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
    ]);

    $product = \App\Models\Product::findOrFail($id);
    $product->update($request->all());

    return Redirect::route('products.index')->with('success', '商品情報を更新しました！');    }

    // 削除処理（未実装）
    public function destroy($id)
    {
            $product = Product::findOrFail($id);
            $product->delete();

            return Redirect::route('products.index')->with('success', '商品を削除しました！');
    }
}
